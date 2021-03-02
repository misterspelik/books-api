<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\User;
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
        $this->userService = $userService;
    }

}