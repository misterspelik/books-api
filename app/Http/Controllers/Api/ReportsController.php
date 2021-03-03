<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\ReportService;

class ReportsController extends Controller
{
    /**
     * @var ReportService
     */
    private $reportService;


    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {
        $data = $this->reportService->getReportData(
            $request->all()
        );

        return response()->json($data);
    }
}