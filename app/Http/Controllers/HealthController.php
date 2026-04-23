<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class HealthController extends Controller
{
    /**
     * Health check endpoint for Render
     */
    public function index()
    {
        try {
            // Check database connection
            DB::connection()->getPdo();
            
            // Check Redis connection (if configured)
            $redisStatus = 'connected';
            if (config('cache.driver') === 'redis') {
                Redis::ping();
            }
            
            return response()->json([
                'status' => 'healthy',
                'timestamp' => now()->toISOString(),
                'database' => 'connected',
                'redis' => $redisStatus,
                'version' => app()->version(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'unhealthy',
                'timestamp' => now()->toISOString(),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
