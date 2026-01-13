<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddcaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'client_id' => 'required|integer|exists:addclients,id',
            'file_number' => 'required|string|max:100|unique:addcases,file_number,' . $this->route('addcase'),
            'branch_id' => 'nullable|integer|exists:client_branches,id',
            'loan_account_acquest_cin' => 'nullable|string|max:50',
            'previous_date' => 'nullable|date_format:Y-m-d',
            'previous_step' => 'nullable|string|max:255',
            'court_id' => 'required|integer|exists:courts,id',
            'case_number' => 'required|string|max:100',
            'section' => 'nullable|string|max:100',
            'name_of_parties' => 'required|string|max:500',
            'legal_notice_date' => 'nullable|date_format:Y-m-d',
            'filing_or_received_date' => 'required|date_format:Y-m-d',
            'next_hearing_date' => 'nullable|date_format:Y-m-d',
            'next_step' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'legal_notice' => 'nullable|file|mimes:pdf,doc,docx,txt,jpeg,png,jpg,gif|max:2048',
            'plaints' => 'nullable|file|mimes:pdf,doc,docx,txt,jpeg,png,jpg,gif|max:2048',
            'others_documents' => 'nullable|file|mimes:pdf,doc,docx,txt,jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'client_id.required' => 'Client is required.',
            'client_id.exists' => 'Selected client does not exist.',
            'file_number.required' => 'File number is required.',
            'file_number.max' => 'File number cannot exceed 100 characters.',
            'file_number.unique' => 'This file number already exists. Please use a unique file number.',
            'branch_id.exists' => 'Selected branch does not exist.',
            'loan_account_acquest_cin.max' => 'Loan account CIN cannot exceed 50 characters.',
            'previous_step.max' => 'Previous step cannot exceed 255 characters.',
            'court_id.required' => 'Court is required.',
            'court_id.exists' => 'Selected court does not exist.',
            'case_number.required' => 'Case number is required.',
            'case_number.max' => 'Case number cannot exceed 100 characters.',
            'section.max' => 'Section cannot exceed 100 characters.',
            'name_of_parties.required' => 'Name of parties is required.',
            'name_of_parties.max' => 'Name of parties cannot exceed 500 characters.',
            'previous_date.date_format' => 'Previous date must be in YYYY-MM-DD format.',
            'legal_notice_date.date_format' => 'Legal notice date must be in YYYY-MM-DD format.',
            'filing_or_received_date.required' => 'Filing or received date is required.',
            'filing_or_received_date.date_format' => 'Filing date must be in YYYY-MM-DD format.',
            'next_hearing_date.date_format' => 'Next hearing date must be in YYYY-MM-DD format.',
            'next_step.max' => 'Next step cannot exceed 255 characters.',
            'legal_notice.file' => 'Legal notice must be a valid file.',
            'legal_notice.mimes' => 'Legal notice must be a PDF, Word document, text, or image file.',
            'legal_notice.max' => 'Legal notice file size cannot exceed 2MB.',
            'plaints.file' => 'Plaints must be a valid file.',
            'plaints.mimes' => 'Plaints must be a PDF, Word document, text, or image file.',
            'plaints.max' => 'Plaints file size cannot exceed 2MB.',
            'others_documents.file' => 'Other documents must be a valid file.',
            'others_documents.mimes' => 'Other documents must be a PDF, Word document, text, or image file.',
            'others_documents.max' => 'Other documents file size cannot exceed 2MB.',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     */
    public function attributes(): array
    {
        return [
            'client_id' => 'Client',
            'file_number' => 'File Number',
            'branch_id' => 'Branch',
            'loan_account_acquest_cin' => 'Loan Account CIN',
            'previous_date' => 'Previous Date',
            'previous_step' => 'Previous Step',
            'court_id' => 'Court',
            'case_number' => 'Case Number',
            'section' => 'Section',
            'name_of_parties' => 'Name of Parties',
            'legal_notice_date' => 'Legal Notice Date',
            'filing_or_received_date' => 'Filing/Received Date',
            'next_hearing_date' => 'Next Hearing Date',
            'next_step' => 'Next Step',
            'status' => 'Status',
            'legal_notice' => 'Legal Notice',
            'plaints' => 'Plaints',
            'others_documents' => 'Other Documents',
        ];
    }
}
