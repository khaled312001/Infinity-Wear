<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HealthController extends Controller
{
    /**
     * Check database health
     */
    public function database()
    {
        try {
            // Test database connection
            DB::connection()->getPdo();
            
            // Test a simple query
            $result = DB::select('SELECT 1 as test');
            
            return response()->json([
                'status' => 'healthy',
                'database' => 'connected',
                'timestamp' => now()->toISOString()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'unhealthy',
                'database' => 'disconnected',
                'error' => $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 503);
        }
    }
    
    /**
     * Check application health
     */
    public function index()
    {
        $health = [
            'status' => 'healthy',
            'timestamp' => now()->toISOString(),
            'services' => []
        ];
        
        // Check database
        try {
            DB::connection()->getPdo();
            $health['services']['database'] = 'healthy';
        } catch (\Exception $e) {
            $health['services']['database'] = 'unhealthy';
            $health['status'] = 'degraded';
        }
        
        // Check cache
        try {
            Cache::put('health_check', 'ok', 60);
            $health['services']['cache'] = 'healthy';
        } catch (\Exception $e) {
            $health['services']['cache'] = 'unhealthy';
            $health['status'] = 'degraded';
        }
        
        return response()->json($health);
    }
}
