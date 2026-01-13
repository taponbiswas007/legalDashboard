<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required|numeric|digits:11',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->number = $request->number;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
    public function showMessage($id)
    {

        $message = Contact::findOrfail($id);
        $message->update(['read' => true]);
        return view('backendPage.showMessage', compact('message'));
    }

    /**
     * Show all messages page
     */
    public function allMessages()
    {
        $messages = Contact::orderBy('created_at', 'desc')->get();
        return view('backendPage.messages.all', compact('messages'));
    }

    /**
     * Mark all messages as read
     */
    public function markAllMessagesRead()
    {
        Contact::where('read', false)->update(['read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'All messages marked as read'
        ]);
    }

    /**
     * Update admin notes for a message
     */
    public function updateMessageNotes(Request $request, $id)
    {
        $message = Contact::findOrFail($id);

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:2000'
        ]);

        $message->update([
            'admin_notes' => $validated['admin_notes']
        ]);

        return back()->with('success', 'Notes updated successfully');
    }

    /**
     * Delete a message
     */
    public function destroyMessage($id)
    {
        $message = Contact::findOrFail($id);
        $message->delete();

        return redirect()->route('messages.all')->with('success', 'Message deleted successfully');
    }
}
