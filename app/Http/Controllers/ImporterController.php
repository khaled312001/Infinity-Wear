<?php

namespace App\Http\Controllers;

use App\Models\Importer;
use App\Models\ImporterOrder;
use App\Models\Task;
use App\Models\User;
use App\Services\AIDesignService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ImporterController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
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
        return view('importers.form');
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
            'design_option' => 'required|string|in:text,upload,template',
            'design_details_text' => 'required_if:design_option,text|nullable|string',
            'design_file' => 'required_if:design_option,upload|nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'design_upload_notes' => 'nullable|string',
            'design_3d_tshirt' => 'required_if:design_option,template|nullable|array',
            'design_3d_shorts' => 'nullable|array',
            'design_3d_socks' => 'nullable|array',
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
                $designDetails['3d_design'] = [
                    'tshirt' => $validated['design_3d_tshirt'] ?? null,
                    'shorts' => $validated['design_3d_shorts'] ?? null,
                    'socks' => $validated['design_3d_socks'] ?? null,
                ];
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

        // إنشاء إشعار لطلب المستورد الجديد
        $this->notificationService->createImporterOrderNotification($order);

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

    /**
     * API endpoint for AI design assistance
     */
    public function aiDesignAssistance(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000',
            'style' => 'required|string|in:realistic,modern,minimalist,sporty,elegant'
        ]);

        try {
            $aiService = new AIDesignService();
            $result = $aiService->generateDesignDescription($request->prompt, $request->style);
            
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('AI Assistance Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ في خدمة الذكاء الاصطناعي'
            ], 500);
        }
    }

    /**
     * API endpoint for design analysis
     */
    public function analyzeDesignRequirements(Request $request)
    {
        $request->validate([
            'requirements' => 'required|string|max:2000'
        ]);

        try {
            $aiService = new AIDesignService();
            $result = $aiService->analyzeDesignRequirements($request->requirements);
            
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Design Analysis Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ في تحليل المتطلبات'
            ], 500);
        }
    }

    /**
     * API endpoint for AI design generation
     */
    public function generateDesign(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000'
        ]);

        try {
            $aiService = new \App\Services\AIDesignService();
            $result = $aiService->generateTShirtDesign($request->prompt);
            
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('AI Design Generation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ في إنشاء التصميم'
            ], 500);
        }
    }
}