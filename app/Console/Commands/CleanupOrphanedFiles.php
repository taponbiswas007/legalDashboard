<?php

namespace App\Console\Commands;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Console\Command;

class CleanupOrphanedFiles extends Command
{
    protected $signature = 'files:cleanup-orphaned';
    protected $description = 'Remove orphaned files that no longer have database records';

    public function handle()
    {
        $this->info('Starting cleanup of orphaned files...');

        // Cleanup orphaned job circular PDFs
        $this->cleanupJobCirculars();

        // Cleanup orphaned CV files
        $this->cleanupCVFiles();

        $this->info('Cleanup complete!');
    }

    private function cleanupJobCirculars()
    {
        $directory = public_path('uploads/job_circulars');

        if (!is_dir($directory)) {
            $this->warn('Job circulars directory does not exist.');
            return;
        }

        $files = array_diff(scandir($directory), ['.', '..']);
        $dbFiles = Job::whereNotNull('pdf_file')->pluck('pdf_file')->toArray();

        $deleted = 0;
        foreach ($files as $file) {
            if (!in_array($file, $dbFiles)) {
                unlink($directory . '/' . $file);
                $this->line("Deleted orphaned job circular: {$file}");
                $deleted++;
            }
        }

        $this->info("Deleted {$deleted} orphaned job circular file(s).");
    }

    private function cleanupCVFiles()
    {
        $directory = public_path('uploads/cvs');

        if (!is_dir($directory)) {
            $this->warn('CVs directory does not exist.');
            return;
        }

        $files = array_diff(scandir($directory), ['.', '..']);
        $dbFiles = JobApplication::whereNotNull('cv_file')->pluck('cv_file')->toArray();

        $deleted = 0;
        foreach ($files as $file) {
            if (!in_array($file, $dbFiles)) {
                unlink($directory . '/' . $file);
                $this->line("Deleted orphaned CV: {$file}");
                $deleted++;
            }
        }

        $this->info("Deleted {$deleted} orphaned CV file(s).");
    }
}
