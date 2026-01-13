<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::latest()->paginate(15);
        return view('backendPage.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('backendPage.jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'job_type' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'salary_range' => 'nullable|string|max:100',
            'deadline' => 'required|date|after:today',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'is_published' => 'boolean'
        ]);

        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $filename = 'job_circular_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/job_circulars'), $filename);
            $validated['pdf_file'] = $filename;
        }

        Job::create($validated);

        return redirect()->route('jobs.index')->with('success', 'Job posted successfully!');
    }

    public function show(Job $job)
    {
        return view('backendPage.jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        return view('backendPage.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'job_type' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'salary_range' => 'nullable|string|max:100',
            'deadline' => 'required|date',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'is_published' => 'boolean'
        ]);

        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('pdf_file')) {
            // Delete old file
            if ($job->pdf_file && file_exists(public_path('uploads/job_circulars/' . $job->pdf_file))) {
                unlink(public_path('uploads/job_circulars/' . $job->pdf_file));
            }

            $file = $request->file('pdf_file');
            $filename = 'job_circular_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/job_circulars'), $filename);
            $validated['pdf_file'] = $filename;
        }

        $job->update($validated);

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job)
    {
        // Delete PDF file
        if ($job->pdf_file && file_exists(public_path('uploads/job_circulars/' . $job->pdf_file))) {
            unlink(public_path('uploads/job_circulars/' . $job->pdf_file));
        }

        // Delete all CV files from applications
        foreach ($job->applications as $application) {
            if ($application->cv_file && file_exists(public_path('uploads/cvs/' . $application->cv_file))) {
                unlink(public_path('uploads/cvs/' . $application->cv_file));
            }
        }

        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully!');
    }

    public function applications(Job $job)
    {
        $applications = $job->applications()->latest()->paginate(20);
        return view('backendPage.jobs.applications', compact('job', 'applications'));
    }

    public function updateApplicationStatus(Request $request, JobApplication $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,rejected',
            'admin_notes' => 'nullable|string'
        ]);

        $application->update($validated);

        return back()->with('success', 'Application status updated!');
    }

    public function downloadCV(JobApplication $application)
    {
        $filePath = public_path('uploads/cvs/' . $application->cv_file);

        if (!file_exists($filePath)) {
            return back()->with('error', 'CV file not found!');
        }

        return response()->download($filePath);
    }
}
