<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        $listConversionReport = getConversionReportShopee();
        $listConversionReport = $listConversionReport['data']['conversionReport']['nodes'] ?? [];

        return view('admin.dashboard.index', compact('listConversionReport'));
    }
}
