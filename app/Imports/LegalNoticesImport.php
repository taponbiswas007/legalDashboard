<?php

namespace App\Imports;

use App\Models\LegalNotice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class LegalNoticesImport implements ToCollection, WithHeadingRow
{
    private $clientId;
    private $branchId;
    private $categoryId;
    private $rowCount = 0;
    private $importedCount = 0;
    private $skippedCount = 0;
    private $errors = [];

    public function __construct($clientId, $branchId, $categoryId)
    {
        $this->clientId = $clientId;
        $this->branchId = $branchId;
        $this->categoryId = $categoryId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $this->rowCount++;

            try {
                // Debug: Log the row data to see what's coming
                Log::info("Importing row {$index}: ", $row->toArray());

                // Map Excel columns to database fields
                // Note: client_id, branch_id, and notice_category_id come from modal selection
                $loanAccount = $row['loan_a_c_acquest_cin'] ?? $row['loan_account_acquest_cin'] ?? null;
                $nameOfAccuest = $row['name_of_acquest'] ?? $row['name_of_accuest'] ?? $row['name'] ?? null;
                $noticeDate = $row['notice_date'] ?? $row['legal_notice_date'] ?? null;
                $dateline = $row['dateline'] ?? $row['dateline_for_filing'] ?? null;
                $comments = $row['comments'] ?? $row['Comments'] ?? null;
                $status = $row['status'] ?? $row['Status'] ?? 'Running';

                // Skip empty rows
                if (empty($nameOfAccuest) && empty($noticeDate)) {
                    $this->skippedCount++;
                    continue;
                }

                // Validate required fields
                if (empty($nameOfAccuest) || empty($noticeDate)) {
                    $this->errors[] = "Row " . ($index + 2) . ": Missing required fields (Name of Acquest or Notice Date)";
                    $this->skippedCount++;
                    continue;
                }

                // Format dates
                $formattedNoticeDate = $this->formatDate($noticeDate);
                $formattedDateline = !empty($dateline) ? $this->formatDate($dateline) : null;

                if (!$formattedNoticeDate) {
                    $this->errors[] = "Row " . ($index + 2) . ": Invalid Notice Date format: " . $noticeDate;
                    $this->skippedCount++;
                    continue;
                }

                // Create the record
                LegalNotice::create([
                    'client_id' => $this->clientId,
                    'branch_id' => $this->branchId,
                    'loan_account_acquest_cin' => $loanAccount,
                    'notice_category_id' => $this->categoryId,
                    'legal_notice_date' => $formattedNoticeDate,
                    'name' => $nameOfAccuest,
                    'dateline_for_filing' => $formattedDateline,
                    'comments' => $comments,
                    'status' => $status,
                ]);

                $this->importedCount++;
            } catch (\Exception $e) {
                $this->errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                $this->skippedCount++;
                Log::error("Import error at row {$index}: " . $e->getMessage());
            }
        }
    }

    private function formatDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            // If it's already a Carbon instance
            if ($date instanceof \Carbon\Carbon) {
                return $date->format('Y-m-d');
            }

            // If it's an Excel serial date
            if (is_numeric($date)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
            }

            // Try different date formats
            $formats = ['Y-m-d', 'd/m/Y', 'm/d/Y', 'd-m-Y', 'm-d-Y', 'Y/m/d', 'd M Y', 'd F Y'];

            foreach ($formats as $format) {
                try {
                    $parsedDate = Carbon::createFromFormat($format, $date);
                    if ($parsedDate !== false) {
                        return $parsedDate->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            // If all else fails, try strtotime
            $timestamp = strtotime($date);
            if ($timestamp !== false) {
                return date('Y-m-d', $timestamp);
            }

            return null;
        } catch (\Exception $e) {
            Log::error("Date formatting error for '{$date}': " . $e->getMessage());
            return null;
        }
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getImportedCount()
    {
        return $this->importedCount;
    }

    public function getSkippedCount()
    {
        return $this->skippedCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
