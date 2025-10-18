<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TaskCard;
use App\Models\PortfolioItem;
use App\Models\Testimonial;
use App\Models\SectionContent;
use App\Models\WhatsAppMessage;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // المهام المرتبطة بالتسويق
        $tasks = TaskCard::where('department', 'marketing')
            ->orderBy('created_at', 'desc')
            ->get();

        // إحصائيات المهام
        $taskStats = [
            'total' => $tasks->count(),
            'pending' => $tasks->where('status', 'pending')->count(),
            'in_progress' => $tasks->where('status', 'in_progress')->count(),
            'completed' => $tasks->where('status', 'completed')->count(),
        ];

        // المهام العاجلة
        $urgentTasks = $tasks->where('priority', 'urgent')
            ->where('status', '!=', 'completed')
            ->take(5);

        // المحتوى التسويقي
        $marketingContent = [
            'portfolio_items' => PortfolioItem::count(),
            'testimonials' => Testimonial::count(),
            'hero_sliders' => 0, // Placeholder for hero sliders
            'home_sections' => SectionContent::count(),
        ];

        // رسائل الواتساب
        $whatsappStats = [
            'total_messages' => WhatsAppMessage::count(),
            'sent_messages' => WhatsAppMessage::where('direction', 'outbound')->count(),
            'received_messages' => WhatsAppMessage::where('direction', 'inbound')->count(),
            'today_messages' => WhatsAppMessage::whereDate('sent_at', Carbon::today())->count(),
        ];

        // إحصائيات جهات الاتصال المشتركة
        $contactStats = [
            'total' => Contact::count(),
            'new' => Contact::new()->count(),
            'read' => Contact::read()->count(),
            'replied' => Contact::replied()->count(),
            'closed' => Contact::closed()->count(),
            'today' => Contact::whereDate('created_at', Carbon::today())->count(),
        ];

        // المحتوى الحديث
        $recentPortfolio = PortfolioItem::orderBy('created_at', 'desc')->limit(5)->get();
        $recentTestimonials = Testimonial::orderBy('created_at', 'desc')->limit(5)->get();
        $recentSliders = collect(); // Placeholder for hero sliders

        // إحصائيات المحتوى حسب النوع
        $contentStats = [
            'featured_portfolio' => PortfolioItem::where('is_featured', true)->count(),
            'active_testimonials' => Testimonial::where('is_active', true)->count(),
            // Active sliders and sections removed
        ];

        // النشاط الأخير
        $recentActivity = collect();

        // إضافة المهام الجديدة
        $tasks->take(5)->each(function ($task) use ($recentActivity) {
            $recentActivity->push([
                'type' => 'task',
                'title' => 'مهمة جديدة',
                'description' => $task->title,
                'time' => $task->created_at,
                'icon' => 'fas fa-tasks',
                'color' => 'warning'
            ]);
        });

        // إضافة المحتوى الجديد
        $recentPortfolio->each(function ($item) use ($recentActivity) {
            $recentActivity->push([
                'type' => 'portfolio',
                'title' => 'مشروع جديد',
                'description' => $item->title,
                'time' => $item->created_at,
                'icon' => 'fas fa-images',
                'color' => 'info'
            ]);
        });

        // إضافة التقييمات الجديدة
        $recentTestimonials->each(function ($testimonial) use ($recentActivity) {
            $recentActivity->push([
                'type' => 'testimonial',
                'title' => 'تقييم جديد',
                'description' => "تقييم من {$testimonial->client_name}",
                'time' => $testimonial->created_at,
                'icon' => 'fas fa-star',
                'color' => 'success'
            ]);
        });

        // ترتيب النشاط حسب الوقت
        $recentActivity = $recentActivity->sortByDesc('time')->take(10);

        return view('marketing.dashboard', compact(
            'user',
            'tasks',
            'taskStats',
            'urgentTasks',
            'marketingContent',
            'whatsappStats',
            'contactStats',
            'recentPortfolio',
            'recentTestimonials',
            'recentSliders',
            'contentStats',
            'recentActivity'
        ));
    }

    public function portfolio()
    {
        $portfolio = PortfolioItem::orderBy('created_at', 'desc')
            ->paginate(20);

        return view('marketing.portfolio.index', compact('portfolio'));
    }

    public function createPortfolio()
    {
        return view('marketing.portfolio.create');
    }

    public function storePortfolio(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'client_name' => 'required|string|max:255',
            'completion_date' => 'required|date',
            'category' => 'required|string|max:100',
            'is_featured' => 'boolean',
        ]);

        // معالجة الصورة الرئيسية
        $imagePath = $request->file('image')->store('images/portfolio', 'public');
        
        // نسخ الصورة إلى public/images/portfolio أيضاً
        $publicImagePath = 'images/portfolio/' . basename($imagePath);
        $request->file('image')->move(public_path('images/portfolio'), basename($imagePath));

        // معالجة معرض الصور
        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $galleryPath = $image->store('images/portfolio/gallery', 'public');
                // نسخ صورة المعرض إلى public أيضاً
                $publicGalleryPath = 'images/portfolio/gallery/' . basename($galleryPath);
                $image->move(public_path('images/portfolio/gallery'), basename($galleryPath));
                $gallery[] = $publicGalleryPath;
            }
        }

        $portfolio = PortfolioItem::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $publicImagePath, // استخدام المسار في public
            'gallery' => $gallery,
            'client_name' => $request->client_name,
            'completion_date' => $request->completion_date,
            'category' => $request->category,
            'is_featured' => $request->has('is_featured'),
            'sort_order' => PortfolioItem::count() + 1,
        ]);

        return redirect()->route('marketing.portfolio.index')
            ->with('success', 'تم إضافة المشروع بنجاح');
    }

    public function testimonials()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')
            ->paginate(20);

        return view('marketing.testimonials.index', compact('testimonials'));
    }

    public function createTestimonial()
    {
        return view('marketing.testimonials.create');
    }

    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'required|string|max:255',
            'client_company' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $testimonial = Testimonial::create([
            'client_name' => $request->input('client_name'),
            'client_title' => $request->input('client_title'),
            'content' => $request->input('content'),
            'rating' => $request->input('rating'),
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('marketing.testimonials.index')
            ->with('success', 'تم إضافة التقييم بنجاح');
    }

    // Slider methods removed

    public function tasks()
    {
        $tasks = TaskCard::where('department', 'marketing')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('marketing.tasks.index', compact('tasks'));
    }

    public function updateTaskStatus(Request $request, TaskCard $task)
    {
        $user = Auth::user();
        
        // التحقق من أن المهمة مرتبطة بالتسويق
        if ($task->department !== 'marketing') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'ليس لديك صلاحية لتعديل هذه المهمة'], 403);
            }
            return redirect()->back()->with('error', 'ليس لديك صلاحية لتعديل هذه المهمة');
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
            'notes' => 'nullable|string|max:1000'
        ]);

        $task->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'completed_at' => $request->status === 'completed' ? Carbon::now() : null,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'تم تحديث حالة المهمة بنجاح']);
        }

        return redirect()->back()->with('success', 'تم تحديث حالة المهمة بنجاح');
    }

    public function whatsapp()
    {
        $messages = WhatsAppMessage::orderBy('sent_at', 'desc')
            ->paginate(20);

        return view('marketing.whatsapp.index', compact('messages'));
    }

    public function reports()
    {
        // تقارير التسويق
        $contentReport = [
            'portfolio_by_category' => PortfolioItem::select('category', DB::raw('COUNT(*) as count'))
                ->groupBy('category')
                ->get(),
            'testimonials_by_rating' => Testimonial::select('rating', DB::raw('COUNT(*) as count'))
                ->groupBy('rating')
                ->get(),
            'active_content' => [
                // Sliders and sections removed
                'portfolio' => PortfolioItem::where('is_featured', true)->count(),
                'testimonials' => Testimonial::where('is_active', true)->count(),
            ]
        ];

        return view('marketing.reports', compact('contentReport'));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('marketing.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:1000',
        ]);

        // Update user profile
        DB::table('users')->where('id', $user->id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'bio' => $request->input('bio'),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function editPortfolio(PortfolioItem $portfolioItem)
    {
        return view('marketing.portfolio.edit', compact('portfolioItem'));
    }

    public function updatePortfolio(Request $request, PortfolioItem $portfolioItem)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'client_name' => 'required|string|max:255',
            'completion_date' => 'required|date',
            'category' => 'required|string|max:100',
            'is_featured' => 'boolean',
        ]);

        $data = $request->except(['image', 'gallery']);
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/portfolio', 'public');
            // نسخ الصورة إلى public/images/portfolio أيضاً
            $publicImagePath = 'images/portfolio/' . basename($imagePath);
            $request->file('image')->move(public_path('images/portfolio'), basename($imagePath));
            $data['image'] = $publicImagePath;
        }
        
        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPath = $file->store('images/portfolio/gallery', 'public');
                // نسخ صورة المعرض إلى public أيضاً
                $publicGalleryPath = 'images/portfolio/gallery/' . basename($galleryPath);
                $file->move(public_path('images/portfolio/gallery'), basename($galleryPath));
                $gallery[] = $publicGalleryPath;
            }
            $data['gallery'] = json_encode($gallery);
        }

        $portfolioItem->update($data);

        return redirect()->route('marketing.portfolio')->with('success', 'تم تحديث المشروع بنجاح');
    }

    public function destroyPortfolio(PortfolioItem $portfolioItem)
    {
        $portfolioItem->delete();
        return redirect()->route('marketing.portfolio')->with('success', 'تم حذف المشروع بنجاح');
    }

    public function editTestimonial(Testimonial $testimonial)
    {
        return view('marketing.testimonials.edit', compact('testimonial'));
    }

    public function updateTestimonial(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'is_featured' => 'boolean',
        ]);

        $testimonial->update($request->all());

        return redirect()->route('marketing.testimonials')->with('success', 'تم تحديث التقييم بنجاح');
    }

    public function destroyTestimonial(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('marketing.testimonials')->with('success', 'تم حذف التقييم بنجاح');
    }

    /**
     * عرض جهات الاتصال المشتركة
     */
    public function contacts(Request $request)
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
                  ->orWhere('phone', 'like', "%{$search}%")
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

        return view('marketing.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * عرض تفاصيل جهة الاتصال
     */
    public function showContact(Contact $contact)
    {
        // Mark as read if it's new
        if ($contact->status === 'new') {
            $contact->markAsRead();
        }

        return view('marketing.contacts.show', compact('contact'));
    }

    /**
     * تحديث حالة جهة الاتصال
     */
    public function updateContact(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied,closed',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $contact->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'read_at' => $request->status === 'read' && !$contact->read_at ? now() : $contact->read_at,
            'replied_at' => $request->status === 'replied' && !$contact->replied_at ? now() : $contact->replied_at,
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة جهة الاتصال بنجاح');
    }

    /**
     * وضع علامة مقروء
     */
    public function markContactAsRead(Contact $contact)
    {
        $contact->markAsRead();
        return redirect()->back()->with('success', 'تم وضع علامة مقروء');
    }

    /**
     * وضع علامة تم الرد
     */
    public function markContactAsReplied(Contact $contact)
    {
        $contact->markAsReplied();
        return redirect()->back()->with('success', 'تم وضع علامة تم الرد');
    }

    /**
     * إغلاق جهة الاتصال
     */
    public function markContactAsClosed(Contact $contact)
    {
        $contact->markAsClosed();
        return redirect()->back()->with('success', 'تم إغلاق جهة الاتصال');
    }
}