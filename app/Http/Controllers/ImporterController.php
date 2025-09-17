<?php

namespace App\Http\Controllers;

use App\Models\Importer;
use App\Models\ImporterOrder;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ImporterController extends Controller
{
    /**
     * عرض قائمة المستوردين
     */
    public function index()
    {
        $importers = Importer::latest()->paginate(15);
        return view('admin.importers.index', compact('importers'));
    }

    /**
     * عرض نموذج إنشاء مستورد جديد
     */
    public function create()
    {
        return view('admin.importers.create');
    }

    /**
     * حفظ مستورد جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company_name' => 'required|string|max:255',
            'business_type' => 'required|string|in:academy,school,store,hospital,other',
            'business_type_other' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'status' => 'required|string|in:new,contacted,qualified,proposal,negotiation,closed_won,closed_lost',
        ]);

        $importer = Importer::create($validated);

        return redirect()->route('admin.importers.index')
            ->with('success', 'تم إضافة المستورد بنجاح');
    }

    /**
     * عرض تفاصيل المستورد
     */
    public function show(Importer $importer)
    {
        $orders = $importer->orders()->latest()->get();
        $tasks = $importer->tasks()->latest()->get();
        
        return view('admin.importers.show', compact('importer', 'orders', 'tasks'));
    }

    /**
     * عرض نموذج تعديل المستورد
     */
    public function edit(Importer $importer)
    {
        return view('admin.importers.edit', compact('importer'));
    }

    /**
     * تحديث بيانات المستورد
     */
    public function update(Request $request, Importer $importer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company_name' => 'required|string|max:255',
            'business_type' => 'required|string|in:academy,school,store,hospital,other',
            'business_type_other' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'status' => 'required|string|in:new,contacted,qualified,proposal,negotiation,closed_won,closed_lost',
        ]);

        $importer->update($validated);

        return redirect()->route('admin.importers.index')
            ->with('success', 'تم تحديث بيانات المستورد بنجاح');
    }

    /**
     * حذف المستورد
     */
    public function destroy(Importer $importer)
    {
        $importer->delete();

        return redirect()->route('admin.importers.index')
            ->with('success', 'تم حذف المستورد بنجاح');
    }

    /**
     * عرض استمارة طلب المستورد (للواجهة الأمامية)
     */
    public function showImporterForm()
    {
        return view('importers.form')->withErrors([]);
    }

    /**
     * معالجة استمارة طلب المستورد (للواجهة الأمامية)
     */
    public function submitImporterForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company_name' => 'required|string|max:255',
            'business_type' => 'required|string|in:academy,school,store,hospital,other',
            'business_type_other' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'requirements' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'design_option' => 'required|string|in:text,upload,template,ai',
            'design_details_text' => 'required_if:design_option,text|nullable|string',
            'design_file' => 'required_if:design_option,upload|nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'design_upload_notes' => 'nullable|string',
            'design_template' => 'required_if:design_option,template|nullable|string',
            'design_template_notes' => 'nullable|string',
            'design_ai_prompt' => 'required_if:design_option,ai|nullable|string',
            'design_ai_style' => 'required_if:design_option,ai|nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // إنشاء حساب مستخدم للمستورد
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'user_type' => 'importer',
        ]);

        // إنشاء سجل المستورد
        $importer = Importer::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company_name' => $validated['company_name'],
            'business_type' => $validated['business_type'],
            'business_type_other' => $validated['business_type_other'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'country' => $validated['country'] ?? null,
            'status' => 'new',
        ]);

        // معالجة تفاصيل التصميم حسب الخيار المحدد
        $designDetails = [
            'option' => $validated['design_option'],
        ];

        switch ($validated['design_option']) {
            case 'text':
                $designDetails['text'] = $validated['design_details_text'];
                break;
            case 'upload':
                if ($request->hasFile('design_file')) {
                    $filePath = $request->file('design_file')->store('designs', 'public');
                    $designDetails['file_path'] = $filePath;
                }
                $designDetails['notes'] = $validated['design_upload_notes'];
                break;
            case 'template':
                $designDetails['template'] = $validated['design_template'];
                $designDetails['notes'] = $validated['design_template_notes'];
                break;
            case 'ai':
                $designDetails['prompt'] = $validated['design_ai_prompt'];
                $designDetails['style'] = $validated['design_ai_style'];
                break;
        }

        // إنشاء طلب المستورد
        $order = ImporterOrder::create([
            'importer_id' => $importer->id,
            'order_number' => ImporterOrder::generateOrderNumber(),
            'status' => 'new',
            'requirements' => $validated['requirements'],
            'quantity' => $validated['quantity'],
            'design_details' => json_encode($designDetails),
        ]);

        // تسجيل الدخول للمستخدم
        Auth::login($user);

        return redirect()->route('importers.dashboard')
            ->with('success', 'تم إنشاء حسابك وتسجيل طلبك بنجاح');
    }

    /**
     * عرض لوحة تحكم المستورد
     */
    public function dashboard()
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }
        
        $orders = $importer->orders()->latest()->get();
        
        return view('importers.dashboard', compact('importer', 'orders'));
    }
}