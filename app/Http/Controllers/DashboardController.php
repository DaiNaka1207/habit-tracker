<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $cacheKey = 'dashboard_stats_' . auth()->id();

        $stats = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            $habits  = auth()->user()->habits()->with('logs')->get();
            $total   = $habits->count();

            if ($total === 0) {
                return ['rate' => 0, 'achieved' => 0, 'total' => 0];
            }

            $achieved = $habits->filter(
                fn($habit) => $habit->logs->contains('date', today()->format('Y-m-d'))
            )->count();

            return [
                'rate'     => round($achieved / $total * 100),
                'achieved' => $achieved,
                'total'    => $total,
            ];
        });

        // アクセスのたびにキャッシュ期限を延長
        Cache::touch($cacheKey, now()->addMinutes(10));

        return view('dashboard', compact('stats'));
    }
}
