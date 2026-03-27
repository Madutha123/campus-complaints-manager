<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComplaintController extends Controller
{
    public function dashboard(): Response
    {
        return response('Admin Dashboard');
    }

    public function index(): Response
    {
        return response('Admin Complaints List');
    }

    public function create(): Response
    {
        return response('Admin Create Complaint');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('admin.complaints.index');
    }

    public function show(Complaint $complaint): Response
    {
        return response('Admin Complaint #'.$complaint->id);
    }

    public function edit(Complaint $complaint): Response
    {
        return response('Admin Edit Complaint #'.$complaint->id);
    }

    public function update(Request $request, Complaint $complaint): RedirectResponse
    {
        return redirect()->route('admin.complaints.show', $complaint);
    }

    public function destroy(Complaint $complaint): RedirectResponse
    {
        return redirect()->route('admin.complaints.index');
    }
}
