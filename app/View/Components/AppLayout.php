<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\Addcase;
use App\Models\Contact;
use App\Models\Subscriber;
use App\Models\JobApplication;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $filenumbers = Addcase::all();
        $messages = Contact::where('read', '=', false)
            ->orderBy('created_at', 'desc')
            ->get();
        $readmessages = Contact::where('read', '=', true)->get();
        $subscribers = Subscriber::where('read_at', null)
            ->orderBy('created_at', 'desc')
            ->get();
        $showsubscribers = Subscriber::whereNotNull('read_at')->get();
        $jobApplications = JobApplication::where('read_at', null)
            ->with('job')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('layouts.app', compact(
            'filenumbers',
            'messages',
            'readmessages',
            'subscribers',
            'showsubscribers',
            'jobApplications'
        ));
    }
}
