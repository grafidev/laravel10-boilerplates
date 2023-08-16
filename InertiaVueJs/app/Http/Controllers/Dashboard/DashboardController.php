<?php

namespace App\Http\Controllers\Dashboard;

use App\Charts\UsersChart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(private UsersChart $usersChart)
    {
    }

    public function __invoke(Request $request)
    {
        $interval = $request->get('interval', 'month');
        if (! in_array($interval, ['day', 'month', 'year'])) {
            $interval = 'month';
        }

        return Inertia::render('Dashboard', [
            'users_chart_data' => $this->usersChart->build($interval),
            'filters' => compact('interval'),
        ]);
    }
}
