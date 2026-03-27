<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    public function dashboard(): View
    {
        $userId = (int) auth()->id();

        $stats = [
            'assigned' => Complaint::query()->where('assigned_to', $userId)->count(),
            'in_progress' => Complaint::query()->where('assigned_to', $userId)->where('status', 'in_progress')->count(),
            'resolved_today' => Complaint::query()
                ->where('assigned_to', $userId)
                ->where('status', 'resolved')
                ->whereDate('resolved_at', now()->toDateString())
                ->count(),
        ];

        $recentComplaints = Complaint::query()
            ->where('assigned_to', $userId)
            ->with(['submitter', 'category', 'department'])
            ->latest()
            ->take(5)
            ->get();

        return view('staff.dashboard', compact('stats', 'recentComplaints'));
    }

    public function index(Request $request): View
    {
        $status = $request->query('status');
        $statuses = ['pending', 'verified', 'assigned', 'in_progress', 'resolved', 'reopened', 'rejected', 'closed'];

        $complaints = Complaint::query()
            ->where('assigned_to', auth()->id())
            ->when($status, fn ($query) => $query->where('status', $status))
            ->with(['submitter', 'category', 'department'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('staff.complaints.index', compact('complaints', 'status', 'statuses'));
    }

    public function show(Complaint $complaint): View
    {
        if ((int) $complaint->assigned_to !== (int) auth()->id()) {
            abort(403);
        }

        $complaint->load([
            'submitter',
            'category',
            'department',
            'assignedTo',
            'comments' => fn ($query) => $query->with('user', 'attachments')->latest(),
            'attachments',
            'activityLogs' => fn ($query) => $query->with('user')->latest(),
        ]);

        $statusOptions = ['in_progress', 'resolved'];

        return view('staff.complaints.show', compact('complaint', 'statusOptions'));
    }

    public function updateStatus(Request $request, Complaint $complaint): RedirectResponse
    {
        if ((int) $complaint->assigned_to !== (int) auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['in_progress', 'resolved'])],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $oldStatus = $complaint->status;
        $newStatus = $validated['status'];

        $complaint->update([
            'status' => $newStatus,
            'resolved_at' => $newStatus === 'resolved' ? now() : null,
        ]);

        ActivityLog::query()->create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(),
            'action' => 'Staff updated complaint status',
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'note' => $validated['note'] ?? null,
        ]);

        return redirect()->route('staff.complaints.show', $complaint)->with('success', 'Status updated successfully.');
    }
}
