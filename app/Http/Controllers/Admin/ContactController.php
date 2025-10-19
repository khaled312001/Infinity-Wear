<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contact::notArchived()->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by contact type
        if ($request->filled('contact_type')) {
            $query->where('contact_type', $request->contact_type);
        }

        // Filter by assigned to
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Filter by tags
        if ($request->filled('tags')) {
            $query->byTags($request->tags);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(20);

        // Statistics
        $stats = [
            'total' => Contact::notArchived()->count(),
            'new' => Contact::notArchived()->new()->count(),
            'read' => Contact::notArchived()->read()->count(),
            'replied' => Contact::notArchived()->replied()->count(),
            'closed' => Contact::notArchived()->closed()->count(),
            'inquiry' => Contact::notArchived()->inquiry()->count(),
            'custom' => Contact::notArchived()->custom()->count(),
            'marketing' => Contact::notArchived()->forMarketing()->count(),
            'sales' => Contact::notArchived()->forSales()->count(),
            'high_priority' => Contact::notArchived()->byPriority('high')->count(),
            'follow_up_today' => Contact::notArchived()->whereDate('follow_up_date', today())->count(),
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

    /**
     * Show the form for creating a new contact.
     */
    public function create()
    {
        return view('admin.contacts.create');
    }

    /**
     * Store a newly created contact in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'contact_type' => 'required|in:inquiry,custom',
            'assigned_to' => 'required|in:marketing,sales,both',
            'priority' => 'required|in:low,medium,high',
            'source' => 'required|in:website,phone,email,referral',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'follow_up_date' => 'nullable|date|after:now',
        ], [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'subject.required' => 'الموضوع مطلوب',
            'message.required' => 'الرسالة مطلوبة',
            'contact_type.required' => 'نوع الجهة مطلوب',
            'assigned_to.required' => 'التعيين مطلوب',
            'priority.required' => 'الأولوية مطلوبة',
            'source.required' => 'المصدر مطلوب',
        ]);

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'new',
            'contact_type' => $request->contact_type,
            'assigned_to' => $request->assigned_to,
            'priority' => $request->priority,
            'source' => $request->source,
            'tags' => $request->tags ?? [],
            'follow_up_date' => $request->follow_up_date,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'تم إنشاء الجهة بنجاح');
    }

    /**
     * Show the form for editing the specified contact.
     */
    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    /**
     * Archive the specified contact.
     */
    public function archive(Contact $contact)
    {
        $contact->archive();

        return redirect()->back()
            ->with('success', 'تم أرشفة الجهة بنجاح');
    }

    /**
     * Unarchive the specified contact.
     */
    public function unarchive(Contact $contact)
    {
        $contact->unarchive();

        return redirect()->back()
            ->with('success', 'تم إلغاء أرشفة الجهة بنجاح');
    }

    /**
     * Assign contact to specific team.
     */
    public function assign(Request $request, Contact $contact)
    {
        $request->validate([
            'assigned_to' => 'required|in:marketing,sales,both'
        ]);

        $contact->assignTo($request->assigned_to);
        $contact->update(['updated_by' => Auth::id()]);

        return redirect()->back()
            ->with('success', 'تم تعيين الجهة بنجاح');
    }

    /**
     * Set contact priority.
     */
    public function setPriority(Request $request, Contact $contact)
    {
        $request->validate([
            'priority' => 'required|in:low,medium,high'
        ]);

        $contact->setPriority($request->priority);
        $contact->update(['updated_by' => Auth::id()]);

        return redirect()->back()
            ->with('success', 'تم تحديث أولوية الجهة بنجاح');
    }

    /**
     * Add tag to contact.
     */
    public function addTag(Request $request, Contact $contact)
    {
        $request->validate([
            'tag' => 'required|string|max:50'
        ]);

        $contact->addTag($request->tag);
        $contact->update(['updated_by' => Auth::id()]);

        return redirect()->back()
            ->with('success', 'تم إضافة العلامة بنجاح');
    }

    /**
     * Remove tag from contact.
     */
    public function removeTag(Request $request, Contact $contact)
    {
        $request->validate([
            'tag' => 'required|string'
        ]);

        $contact->removeTag($request->tag);
        $contact->update(['updated_by' => Auth::id()]);

        return redirect()->back()
            ->with('success', 'تم إزالة العلامة بنجاح');
    }

    /**
     * Set follow-up date for contact.
     */
    public function setFollowUp(Request $request, Contact $contact)
    {
        $request->validate([
            'follow_up_date' => 'required|date|after:now'
        ]);

        $contact->setFollowUpDate($request->follow_up_date);
        $contact->update(['updated_by' => Auth::id()]);

        return redirect()->back()
            ->with('success', 'تم تعيين موعد المتابعة بنجاح');
    }

    /**
     * Bulk assign contacts to team.
     */
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id',
            'assigned_to' => 'required|in:marketing,sales,both'
        ]);

        Contact::whereIn('id', $request->contact_ids)
            ->update([
                'assigned_to' => $request->assigned_to,
                'updated_by' => Auth::id()
            ]);

        return redirect()->back()
            ->with('success', 'تم تعيين الجهات المحددة بنجاح');
    }

    /**
     * Bulk archive contacts.
     */
    public function bulkArchive(Request $request)
    {
        $request->validate([
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id'
        ]);

        Contact::whereIn('id', $request->contact_ids)
            ->update([
                'is_archived' => true,
                'updated_by' => Auth::id()
            ]);

        return redirect()->back()
            ->with('success', 'تم أرشفة الجهات المحددة بنجاح');
    }

    /**
     * Get contacts for specific team (API).
     */
    public function getTeamContacts(Request $request, $team)
    {
        $query = Contact::notArchived();

        if ($team === 'marketing') {
            $query->forMarketing();
        } elseif ($team === 'sales') {
            $query->forSales();
        }

        $contacts = $query->latest()->paginate(20);

        return response()->json([
            'contacts' => $contacts,
            'team' => $team
        ]);
    }
}
