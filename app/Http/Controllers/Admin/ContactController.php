<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contact::latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(20);

        // Statistics
        $stats = [
            'total' => Contact::count(),
            'new' => Contact::new()->count(),
            'read' => Contact::read()->count(),
            'replied' => Contact::replied()->count(),
            'closed' => Contact::closed()->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        // Mark as read if it's new
        if ($contact->status === 'new') {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied,closed',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $contact->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'تم تحديث حالة الرسالة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'تم حذف الرسالة بنجاح');
    }

    /**
     * Mark contact as read
     */
    public function markAsRead(Contact $contact)
    {
        $contact->markAsRead();

        return redirect()->back()
            ->with('success', 'تم تمييز الرسالة كمقروءة');
    }

    /**
     * Mark contact as replied
     */
    public function markAsReplied(Contact $contact)
    {
        $contact->markAsReplied();

        return redirect()->back()
            ->with('success', 'تم تمييز الرسالة كرد عليها');
    }

    /**
     * Mark contact as closed
     */
    public function markAsClosed(Contact $contact)
    {
        $contact->markAsClosed();

        return redirect()->back()
            ->with('success', 'تم إغلاق الرسالة');
    }
}
