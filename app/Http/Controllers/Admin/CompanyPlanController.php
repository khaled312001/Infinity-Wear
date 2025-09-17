<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyPlan;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = CompanyPlan::with(['creator', 'assignee'])
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => CompanyPlan::count(),
            'active' => CompanyPlan::where('status', 'active')->count(),
            'completed' => CompanyPlan::where('status', 'completed')->count(),
            'draft' => CompanyPlan::where('status', 'draft')->count(),
        ];

        return view('admin.company-plans.index', compact('plans', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admins = Admin::where('role', 'admin')->get();
        return view('admin.company-plans.create', compact('admins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:quarterly,semi_annual,annual',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'objectives' => 'required|array|min:1',
            'objectives.*' => 'required|string|max:500',
            'strengths' => 'required|array|min:1',
            'strengths.*' => 'required|string|max:500',
            'weaknesses' => 'required|array|min:1',
            'weaknesses.*' => 'required|string|max:500',
            'opportunities' => 'required|array|min:1',
            'opportunities.*' => 'required|string|max:500',
            'threats' => 'required|array|min:1',
            'threats.*' => 'required|string|max:500',
            'strategies' => 'required|array|min:1',
            'strategies.*' => 'required|string|max:500',
            'action_items' => 'required|array|min:1',
            'action_items.*' => 'required|string|max:500',
            'budget' => 'nullable|numeric|min:0',
            'assigned_to' => 'nullable|exists:admins,id',
            'notes' => 'nullable|string',
        ]);

        $plan = CompanyPlan::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'objectives' => $request->objectives,
            'strengths' => $request->strengths,
            'weaknesses' => $request->weaknesses,
            'opportunities' => $request->opportunities,
            'threats' => $request->threats,
            'strategies' => $request->strategies,
            'action_items' => $request->action_items,
            'budget' => $request->budget,
            'assigned_to' => $request->assigned_to,
            'notes' => $request->notes,
            'created_by' => Auth::guard('admin')->id(),
            'status' => 'draft',
        ]);

        return redirect()->route('admin.company-plans.index')
            ->with('success', 'تم إنشاء الخطة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyPlan $companyPlan)
    {
        $companyPlan->load(['creator', 'assignee']);
        return view('admin.company-plans.show', compact('companyPlan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyPlan $companyPlan)
    {
        $admins = Admin::where('role', 'admin')->get();
        return view('admin.company-plans.edit', compact('companyPlan', 'admins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanyPlan $companyPlan)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:quarterly,semi_annual,annual',
            'status' => 'required|in:draft,active,completed,cancelled',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'objectives' => 'required|array|min:1',
            'objectives.*' => 'required|string|max:500',
            'strengths' => 'required|array|min:1',
            'strengths.*' => 'required|string|max:500',
            'weaknesses' => 'required|array|min:1',
            'weaknesses.*' => 'required|string|max:500',
            'opportunities' => 'required|array|min:1',
            'opportunities.*' => 'required|string|max:500',
            'threats' => 'required|array|min:1',
            'threats.*' => 'required|string|max:500',
            'strategies' => 'required|array|min:1',
            'strategies.*' => 'required|string|max:500',
            'action_items' => 'required|array|min:1',
            'action_items.*' => 'required|string|max:500',
            'budget' => 'nullable|numeric|min:0',
            'actual_cost' => 'nullable|numeric|min:0',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'assigned_to' => 'nullable|exists:admins,id',
            'notes' => 'nullable|string',
        ]);

        $companyPlan->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'objectives' => $request->objectives,
            'strengths' => $request->strengths,
            'weaknesses' => $request->weaknesses,
            'opportunities' => $request->opportunities,
            'threats' => $request->threats,
            'strategies' => $request->strategies,
            'action_items' => $request->action_items,
            'budget' => $request->budget,
            'actual_cost' => $request->actual_cost,
            'progress_percentage' => $request->progress_percentage,
            'assigned_to' => $request->assigned_to,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.company-plans.index')
            ->with('success', 'تم تحديث الخطة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyPlan $companyPlan)
    {
        $companyPlan->delete();

        return redirect()->route('admin.company-plans.index')
            ->with('success', 'تم حذف الخطة بنجاح');
    }

    /**
     * Update plan status
     */
    public function updateStatus(Request $request, CompanyPlan $companyPlan)
    {
        $request->validate([
            'status' => 'required|in:draft,active,completed,cancelled',
        ]);

        $companyPlan->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'تم تحديث حالة الخطة بنجاح');
    }
}
