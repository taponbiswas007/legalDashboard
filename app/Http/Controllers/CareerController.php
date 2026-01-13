<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        $jobs = Job::published()->latest()->paginate(12);
        return view('frontend.careers.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        if (!$job->is_published || $job->deadline < now()) {
            abort(404);
        }

        return view('frontend.careers.show', compact('job'));
    }

    public function apply(Request $request, Job $job)
    {
        if (!$job->is_published || $job->deadline < now()) {
            return back()->with('error', 'This job is no longer accepting applications.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'cover_letter' => 'nullable|string|max:2000',
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120'
        ]);

        $validated['job_id'] = $job->id;

        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $filename = 'cv_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/cvs'), $filename);
            $validated['cv_file'] = $filename;
        }

        JobApplication::create($validated);

        // Update application count
        $job->increment('total_applications');

        return redirect()->route('careers.index')->with('success', 'আপনার আবেদন সফলভাবে জমা দেওয়া হয়েছে!');
    }

    public function downloadCircular(Job $job)
    {
        if (!$job->pdf_file) {
            return back()->with('error', 'No circular file available.');
        }

        $filePath = public_path('uploads/job_circulars/' . $job->pdf_file);

        if (!file_exists($filePath)) {
            return back()->with('error', 'Circular file not found!');
        }

        return response()->download($filePath);
    }

    /**
     * Show job application details
     */
    public function showApplication($id)
    {
        $application = JobApplication::with('job')->findOrFail($id);

        // Mark as read when viewing
        if (!$application->read_at) {
            $application->markAsRead();
        }

        return view('backendPage.jobApplications.show', compact('application'));
    }

    /**
     * Update admin notes for job application
     */
    public function updateApplicationNotes(Request $request, $id)
    {
        $application = JobApplication::findOrFail($id);

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:2000'
        ]);

        $application->update([
            'admin_notes' => $validated['admin_notes']
        ]);

        return back()->with('success', 'Notes updated successfully');
    }
}
