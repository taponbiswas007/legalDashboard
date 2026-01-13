<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Imagegallery;
use App\Models\Stafflist;
use Illuminate\Http\Request;
use App\Models\Trustedclient;
use App\Models\Subscriber;

class FrontendController extends Controller
{
    public function index()
    {
        $stafflists = Stafflist::where('status', '=', '1')->get();
        $xstafflists = Stafflist::where('status', '=', '0')->get();
        $trustedclients = Trustedclient::where('status', '=', '1')->get();
        $blogs = Blog::where('status', '=', '1')->get();
        return view(
            'frontendPage.home',
            compact(
                'stafflists',
                'xstafflists',
                'trustedclients',
                'blogs'
            )
        );
    }

    public function contactus()
    {
        return view('frontendPage.contactus');
    }
    public function showblog($id)
    {
        $blog = Blog::findOrFail($id);
        return view('frontendPage.blog', compact('blog'));
    }
    public function subscriberStore(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'subscriberemail' => [
                'required',
                'email',
                'unique:subscribers,email',
                function ($attribute, $value, $fail) {
                    // Check for common fake/temporary email patterns
                    $fakePatterns = [
                        'tempmail',
                        'throwaway',
                        'guerrillamail',
                        '10minutemail',
                        'mailinator',
                        'maildrop',
                        'trashmail',
                        'yopmail',
                        'fakeinbox',
                        'sharklasers',
                        'getnada',
                        'temp-mail'
                    ];

                    $domain = strtolower(substr(strrchr($value, "@"), 1));

                    foreach ($fakePatterns as $pattern) {
                        if (strpos($domain, $pattern) !== false) {
                            $fail('Please use a valid permanent email address.');
                            return;
                        }
                    }

                    // Additional check for disposable email domains
                    if ($this->isDisposableEmail($domain)) {
                        $fail('Temporary or disposable email addresses are not allowed.');
                    }
                }
            ],
            'read' => 'nullable',
        ]);

        // Create a new subscriber using the validated data
        Subscriber::create([
            'email' => $validated['subscriberemail'],
            'read' => $validated['read'] ?? false,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'You have subscribed successfully');
    }

    /**
     * Check if email domain is disposable/temporary
     */
    private function isDisposableEmail($domain)
    {
        // Extended list of known disposable email domains
        $disposableDomains = [
            'mailinator.com',
            'guerrillamail.com',
            'tempmail.com',
            '10minutemail.com',
            'throwaway.email',
            'maildrop.cc',
            'trashmail.com',
            'yopmail.com',
            'getnada.com',
            'temp-mail.org',
            'fakeinbox.com',
            'sharklasers.com',
            'dispostable.com',
            'throwaway.email',
            'getairmail.com',
            'mytemp.email'
        ];

        return in_array(strtolower($domain), $disposableDomains);
    }

    public function showSubscriber($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        // Mark as read using the model method
        $subscriber->markAsRead();
        return view('backendPage.showSubscriber', compact('subscriber'));
    }

    /**
     * Delete a subscriber
     */
    public function destroySubscriber($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return redirect()->route('notifications.all')->with('success', 'Subscriber deleted successfully');
    }

    // In FrontendController.php
    public function aboutus()
    {
        $stafflists = Stafflist::where('status', '=', '1')->get();
        return view('frontendPage.aboutus', compact('stafflists'));
    }
    public function practice()
    {
        $stafflists = Stafflist::where('status', '=', '1')->get();
        return view('frontendPage.practice', compact('stafflists'));
    }
    public function teams()
    {
        $stafflists = Stafflist::where('status', '=', '1')->get();
        return view('frontendPage.team', compact('stafflists'));
    }
    public function gallery()
    {

        $imagegalleries = Imagegallery::where('status', '=', '1')->get();
        return view('frontendPage.gallery', compact('imagegalleries'));
    }
}
