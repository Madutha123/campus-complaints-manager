<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComplaintController extends Controller
{
    public function dashboard(): Response
    {
        return response('Staff Dashboard');
    }

    public function index(): Response
    {
        return response('Assigned Complaints');
    }

    public function show(Complaint $complaint): Response
    {
        return response('Staff Complaint #'.$complaint->id);
    }

    public function updateStatus(Request $request, Complaint $complaint): RedirectResponse
    {
        return redirect()->route('staff.complaints.show', $complaint);
    }
}
