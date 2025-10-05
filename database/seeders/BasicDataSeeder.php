<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use App\Models\Importer;
use App\Models\Order;
use App\Models\ImporterOrder;
use App\Models\Task;
use App\Models\TaskBoard;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class BasicDataSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء المدراء إذا لم تكن موجودة
        if (Admin::count() == 0) {
            Admin::create([
                'name' => 'أحمد محمد',
                'email' => 'admin@infinitywear.sa',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'is_active' => true,
            ]);
        }

        // إنشاء المستخدمين
        if (User::count() < 10) {
            $this->createUsers();
        }

        // إنشاء المستوردين
        if (Importer::count() < 5) {
            $this->createImporters();
        }

        // إنشاء الطلبات
        if (Order::count() < 10) {
            $this->createOrders();
        }

        // إنشاء طلبات المستوردين
        if (ImporterOrder::count() < 5) {
            $this->createImporterOrders();
        }

        // إنشاء المهام
        if (Task::count() < 10) {
            $this->createTasks();
        }

        // إنشاء المعاملات المالية
        if (Transaction::count() < 20) {
            $this->createTransactions();
        }
    }

    private function createUsers()
    {
        $users = [];
        $cities = ['الرياض', 'جدة', 'مكة', 'المدينة', 'الدمام'];
        
        for ($i = 1; $i <= 10; $i++) {
            $users[] = [
                'name' => 'عميل ' . $i,
                'email' => 'customer' . $i . '@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+9665' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'address' => 'شارع ' . $i . '، حي ' . rand(1, 20),
                'city' => $cities[array_rand($cities)],
                'user_type' => 'importer',
                'created_at' => Carbon::now()->subDays(rand(1, 365)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30)),
            ];
        }

        User::insert($users);
    }

    private function createImporters()
    {
        $importers = [];
        $businessTypes = ['academy', 'school', 'store', 'hospital', 'other'];
        $statuses = ['new', 'contacted', 'qualified', 'proposal', 'negotiation', 'closed_won', 'closed_lost'];
        $cities = ['الرياض', 'جدة', 'مكة', 'المدينة', 'الدمام'];
        
        for ($i = 1; $i <= 5; $i++) {
            $importers[] = [
                'user_id' => null,
                'name' => 'مستورد ' . $i,
                'email' => 'importer' . $i . '@example.com',
                'phone' => '+9665' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'company_name' => 'شركة ' . $i . ' التجارية',
                'business_type' => $businessTypes[array_rand($businessTypes)],
                'business_type_other' => rand(0, 1) ? 'نشاط تجاري آخر' : null,
                'address' => 'شارع ' . $i . '، حي ' . rand(1, 20),
                'city' => $cities[array_rand($cities)],
                'country' => 'السعودية',
                'notes' => 'ملاحظات مهمة للمستورد رقم ' . $i,
                'status' => $statuses[array_rand($statuses)],
                'created_at' => Carbon::now()->subDays(rand(1, 200)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30)),
            ];
        }

        Importer::insert($importers);
    }

    private function createOrders()
    {
        $orders = [];
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $users = User::all();
        
        if ($users->count() > 0) {
            for ($i = 1; $i <= 10; $i++) {
                $user = $users->random();
                $subtotal = rand(100, 5000);
                $tax = $subtotal * 0.15;
                $shipping = rand(20, 100);
                $total = $subtotal + $tax + $shipping;
                
                $orders[] = [
                    'user_id' => $user->id,
                    'order_number' => 'ORD-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                    'status' => $statuses[array_rand($statuses)],
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'shipping' => $shipping,
                    'total' => $total,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone,
                    'shipping_address' => $user->address . '، ' . $user->city,
                    'notes' => rand(0, 1) ? 'ملاحظات خاصة للطلب رقم ' . $i : null,
                    'created_at' => Carbon::now()->subDays(rand(1, 180)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 30)),
                ];
            }

            Order::insert($orders);
        }
    }

    private function createImporterOrders()
    {
        $importerOrders = [];
        $statuses = ['new', 'processing', 'completed', 'cancelled'];
        $importers = Importer::all();
        $admins = Admin::all();
        
        if ($importers->count() > 0 && $admins->count() > 0) {
            for ($i = 1; $i <= 5; $i++) {
                $importer = $importers->random();
                $estimatedCost = rand(1000, 50000);
                $finalCost = $estimatedCost + rand(-5000, 10000);
                
                $importerOrders[] = [
                    'importer_id' => $importer->id,
                    'order_number' => 'IMP-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                    'status' => $statuses[array_rand($statuses)],
                    'requirements' => 'متطلبات خاصة للطلب رقم ' . $i,
                    'quantity' => rand(10, 1000),
                    'design_details' => json_encode([
                        'colors' => ['أحمر', 'أزرق', 'أخضر'],
                        'sizes' => ['S', 'M', 'L', 'XL'],
                        'materials' => ['قطن', 'بوليستر']
                    ]),
                    'estimated_cost' => $estimatedCost,
                    'final_cost' => $finalCost,
                    'delivery_date' => Carbon::now()->addDays(rand(7, 60)),
                    'notes' => 'ملاحظات مهمة للطلب رقم ' . $i,
                    'assigned_to' => $admins->random()->id,
                    'created_at' => Carbon::now()->subDays(rand(1, 150)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 20)),
                ];
            }

            ImporterOrder::insert($importerOrders);
        }
    }

    private function createTasks()
    {
        // إنشاء لوحات المهام
        if (TaskBoard::count() == 0) {
            $boards = [
                ['name' => 'مهام عامة', 'description' => 'المهام العامة للمشروع'],
                ['name' => 'مهام التسويق', 'description' => 'مهام فريق التسويق'],
                ['name' => 'مهام المبيعات', 'description' => 'مهام فريق المبيعات'],
            ];

            foreach ($boards as $board) {
                TaskBoard::create($board);
            }
        }

        $tasks = [];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        $statuses = ['pending', 'in_progress', 'completed', 'cancelled'];
        $departments = ['admin', 'marketing', 'sales'];
        $columns = ['todo', 'in_progress', 'review', 'done'];
        $importers = Importer::all();
        $admins = Admin::all();
        $boards = TaskBoard::all();

        if ($admins->count() > 0 && $boards->count() > 0) {
            for ($i = 1; $i <= 10; $i++) {
                $tasks[] = [
                    'title' => 'مهمة ' . $i,
                    'description' => 'وصف مفصل للمهمة رقم ' . $i . ' مع جميع التفاصيل المطلوبة',
                    'priority' => $priorities[array_rand($priorities)],
                    'status' => $statuses[array_rand($statuses)],
                    'due_date' => Carbon::now()->addDays(rand(-30, 60)),
                    'assigned_to' => $admins->random()->id,
                    'created_by' => $admins->random()->id,
                    'importer_id' => $importers->count() > 0 && rand(0, 1) ? $importers->random()->id : null,
                    'department' => $departments[array_rand($departments)],
                    'board_id' => $boards->random()->id,
                    'column_status' => $columns[array_rand($columns)],
                    'position' => $i,
                    'labels' => json_encode(['مهم', 'عاجل', 'متابعة']),
                    'attachments' => json_encode([]),
                    'checklist' => json_encode([
                        ['id' => 1, 'text' => 'الخطوة الأولى', 'completed' => rand(0, 1)],
                        ['id' => 2, 'text' => 'الخطوة الثانية', 'completed' => rand(0, 1)],
                    ]),
                    'estimated_hours' => rand(1, 40),
                    'actual_hours' => rand(0, 50),
                    'started_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 30)) : null,
                    'completed_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 10)) : null,
                    'time_logs' => json_encode([]),
                    'comments' => json_encode([]),
                    'color' => '#3b82f6',
                    'is_archived' => rand(0, 1),
                    'created_at' => Carbon::now()->subDays(rand(1, 120)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 15)),
                ];
            }

            Task::insert($tasks);
        }
    }

    private function createTransactions()
    {
        $transactions = [];
        $types = ['income', 'expense'];
        $incomeCategories = ['orders', 'custom_designs', 'consultation', 'rush_orders', 'bulk_discount', 'other'];
        $expenseCategories = ['materials', 'manufacturing', 'shipping', 'marketing', 'salaries', 'rent', 'utilities', 'equipment', 'maintenance', 'insurance', 'taxes', 'other'];
        $paymentMethods = ['cash', 'bank_transfer', 'credit_card', 'mada', 'stc_pay', 'paypal', 'other'];
        $statuses = ['pending', 'completed', 'cancelled'];
        $admins = Admin::all();
        $orders = Order::all();

        if ($admins->count() > 0) {
            for ($i = 1; $i <= 20; $i++) {
                $type = $types[array_rand($types)];
                $category = $type === 'income' ? $incomeCategories[array_rand($incomeCategories)] : $expenseCategories[array_rand($expenseCategories)];
                $amount = rand(50, 10000);
                
                $transactions[] = [
                    'type' => $type,
                    'category' => $category,
                    'amount' => $amount,
                    'description' => 'معاملة ' . $type . ' رقم ' . $i . ' - ' . $category,
                    'reference_id' => $type === 'income' && $orders->count() > 0 && rand(0, 1) ? $orders->random()->id : null,
                    'reference_type' => $type === 'income' && rand(0, 1) ? 'order' : 'general',
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'transaction_date' => Carbon::now()->subDays(rand(1, 365)),
                    'status' => $statuses[array_rand($statuses)],
                    'created_by' => $admins->random()->id,
                    'notes' => rand(0, 1) ? 'ملاحظات إضافية للمعاملة رقم ' . $i : null,
                    'created_at' => Carbon::now()->subDays(rand(1, 365)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 30)),
                ];
            }

            Transaction::insert($transactions);
        }
    }
}
