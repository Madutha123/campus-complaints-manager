<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComplaintController extends Controller
{
    public function dashboard(): Response
    {
        return response('Student Dashboard');
    }

    public function index(): Response
    {
        return response('Student Complaints List');
    }

    public function create(): Response
    {
        return response('Student Create Complaint');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('student.complaints.index');
    }

    public function show(Complaint $complaint): Response
    {
        return response('Student Complaint #'.$complaint->id);
    }
}
