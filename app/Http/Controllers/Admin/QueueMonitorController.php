<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class QueueMonitorController extends Controller
{
    /**
     * عرض صفحة مراقبة النظام
     */
    public function index()
    {
        $stats = $this->getQueueStats();
        $recentJobs = $this->getRecentJobs();
        $failedJobs = $this->getFailedJobs();
        
        return view('admin.notifications.queue-monitor', compact('stats', 'recentJobs', 'failedJobs'));
    }

    /**
     * الحصول على إحصائيات النظام
     */
    public function getQueueStats()
    {
        try {
            $pendingJobs = DB::table('jobs')->count();
            $failedJobs = DB::table('failed_jobs')->count();
            $processedJobs = DB::table('jobs')->where('reserved_at', '!=', null)->count();
            
            return [
                'pending_jobs' => $pendingJobs,
                'failed_jobs' => $failedJobs,
                'processed_jobs' => $processedJobs,
                'queue_status' => $this->getQueueStatus(),
                'worker_status' => $this->getWorkerStatus()
            ];
        } catch (\Exception $e) {
            return [
                'pending_jobs' => 0,
                'failed_jobs' => 0,
                'processed_jobs' => 0,
                'queue_status' => 'error',
                'worker_status' => 'unknown'
            ];
        }
    }

    /**
     * الحصول على المهام الأخيرة
     */
    public function getRecentJobs($limit = 10)
    {
        try {
            return DB::table('jobs')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * الحصول على المهام الفاشلة
     */
    public function getFailedJobs($limit = 10)
    {
        try {
            return DB::table('failed_jobs')
                ->orderBy('failed_at', 'desc')
                ->limit($limit)
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * الحصول على حالة النظام
     */
    private function getQueueStatus()
    {
        try {
            $pendingJobs = DB::table('jobs')->count();
            if ($pendingJobs > 100) {
                return 'busy';
            } elseif ($pendingJobs > 0) {
                return 'active';
            } else {
                return 'idle';
            }
        } catch (\Exception $e) {
            return 'error';
        }
    }

    /**
     * الحصول على حالة Worker
     */
    private function getWorkerStatus()
    {
        // محاولة بسيطة للتحقق من وجود worker
        $output = shell_exec('ps aux | grep "queue:work" | grep -v grep');
        return !empty($output) ? 'running' : 'stopped';
    }

    /**
     * إعادة تشغيل المهام الفاشلة
     */
    public function retryFailedJobs()
    {
        try {
            Artisan::call('queue:retry', ['id' => 'all']);
            
            return response()->json([
                'success' => true,
                'message' => 'تم إعادة تشغيل جميع المهام الفاشلة'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * حذف المهام الفاشلة
     */
    public function flushFailedJobs()
    {
        try {
            Artisan::call('queue:flush');
            
            return response()->json([
                'success' => true,
                'message' => 'تم حذف جميع المهام الفاشلة'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * إعادة تشغيل Queue Worker
     */
    public function restartWorker()
    {
        try {
            Artisan::call('queue:restart');
            
            return response()->json([
                'success' => true,
                'message' => 'تم إعادة تشغيل Queue Worker'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * الحصول على إحصائيات محدثة (AJAX)
     */
    public function getStats()
    {
        $stats = $this->getQueueStats();
        
        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}
