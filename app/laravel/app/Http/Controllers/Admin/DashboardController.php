<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        $listConversionReport = Cache::get('listConversionReport') ?? null;

        if (empty($listConversionReport)) {
            $listConversionReport = getConversionReportShopee();
            $listConversionReport = $listConversionReport['data']['conversionReport']['nodes'] ?? [];
            Cache::put('listConversionReport', $listConversionReport, 60);
        }

        return view('admin.dashboard.index', compact('listConversionReport'));
    }
}
