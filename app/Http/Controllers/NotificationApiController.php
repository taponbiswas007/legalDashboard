<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\Contact;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificationApiController extends Controller
{
    /**
     * Check for new notifications since the last check time
     */
    public function checkNewNotifications(Request $request)
    {
        $since = $request->input('since');

        // Convert timestamp to Carbon instance
        $sinceTime = $since ? Carbon::createFromTimestampMs($since) : Carbon::now()->subMinutes(1);

        // Get new unread subscribers
        $newSubscribers = Subscriber::where('created_at', '>', $sinceTime)
            ->whereNull('read_at') // Only unread
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'email', 'created_at'])
            ->map(function ($subscriber) {
                return [
                    'id' => $subscriber->id,
                    'email' => $subscriber->email,
                    'created_at' => $subscriber->created_at->toIso8601String(),
                ];
            });

        // Get new unread messages
        $newMessages = Contact::where('created_at', '>', $sinceTime)
            ->where('read', false) // Only unread
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'name', 'email', 'message', 'created_at'])
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'name' => $message->name,
                    'email' => $message->email,
                    'message' => substr($message->message, 0, 100),
                    'created_at' => $message->created_at->toIso8601String(),
                ];
            });

        // Get new unread job applications
        $newApplications = JobApplication::with('job:id,title')
            ->where('created_at', '>', $sinceTime)
            ->whereNull('read_at') // Only unread
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'job_id', 'name', 'email', 'created_at'])
            ->map(function ($application) {
                return [
                    'id' => $application->id,
                    'name' => $application->name,
                    'email' => $application->email,
                    'job_title' => $application->job ? $application->job->title : 'Unknown Position',
                    'created_at' => $application->created_at->toIso8601String(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'subscribers' => $newSubscribers,
                'messages' => $newMessages,
                'applications' => $newApplications,
            ],
            'timestamp' => now()->timestamp * 1000, // Return current timestamp in milliseconds
        ]);
    }
}
