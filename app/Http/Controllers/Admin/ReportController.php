<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function index(): Response
    {
        return response('Admin Reports');
    }
}
