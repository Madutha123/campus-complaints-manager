<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total' => Complaint::query()->count(),
            'pending' => Complaint::query()->where('status', 'pending')->count(),
            'in_progress' => Complaint::query()->where('status', 'in_progress')->count(),
            'resolved' => Complaint::query()->where('status', 'resolved')->count(),
            'overdue' => Complaint::query()
                ->whereNotNull('due_date')
                ->where('due_date', '<', now())
                ->where('status', '!=', 'closed')
                ->count(),
        ];

        $recentComplaints = Complaint::query()
            ->with(['submitter', 'category', 'department', 'assignedTo'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentComplaints'));
    }

    public function index(Request $request): View
    {
        $filters = [
            'status' => $request->query('status'),
            'category_id' => $request->query('category_id'),
            'department_id' => $request->query('department_id'),
            'priority' => $request->query('priority'),
        ];

        $complaints = Complaint::query()
            ->with(['submitter', 'category', 'department', 'assignedTo'])
            ->when($filters['status'], fn ($query) => $query->where('status', $filters['status']))
            ->when($filters['category_id'], fn ($query) => $query->where('category_id', $filters['category_id']))
            ->when($filters['department_id'], fn ($query) => $query->where('department_id', $filters['department_id']))
            ->when($filters['priority'], fn ($query) => $query->where('priority', $filters['priority']))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statuses = ['pending', 'verified', 'assigned', 'in_progress', 'resolved', 'reopened', 'rejected', 'closed'];
        $priorities = ['low', 'medium', 'high', 'critical'];
        $categories = Category::query()->orderBy('name')->get();
        $departments = Department::query()->orderBy('name')->get();

        return view('admin.complaints.index', compact('complaints', 'filters', 'statuses', 'priorities', 'categories', 'departments'));
    }

    public function create(): Response
    {
        return response('Admin Create Complaint');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('admin.complaints.index');
    }

    public function show(Complaint $complaint): View
    {
        $complaint->load([
            'submitter',
            'category',
            'department',
            'assignedTo',
            'comments' => fn ($query) => $query->with('user', 'attachments')->latest(),
            'attachments',
            'activityLogs' => fn ($query) => $query->with('user')->latest(),
            'feedback',
        ]);

        $staffUsers = User::query()
            ->where('role', 'staff')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $statuses = ['pending', 'verified', 'assigned', 'in_progress', 'resolved', 'reopened', 'rejected', 'closed'];

        return view('admin.complaints.show', compact('complaint', 'staffUsers', 'statuses'));
    }

    public function assign(Request $request, Complaint $complaint): RedirectResponse
    {
        $validated = $request->validate([
            'assigned_to' => [
                'required',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'staff')),
            ],
        ]);

        $oldStatus = $complaint->status;

        $complaint->update([
            'assigned_to' => $validated['assigned_to'],
            'status' => 'assigned',
            'due_date' => now()->addHours((int) $complaint->category->sla_hours),
        ]);

        ActivityLog::query()->create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(),
            'action' => 'Complaint assigned',
            'old_status' => $oldStatus,
            'new_status' => 'assigned',
            'note' => 'Assigned to staff user ID '.$validated['assigned_to'].'.',
        ]);

        return back()->with('success', 'Complaint assigned successfully.');
    }

    public function updateStatus(Request $request, Complaint $complaint): RedirectResponse
    {
        $statuses = ['pending', 'verified', 'assigned', 'in_progress', 'resolved', 'reopened', 'rejected', 'closed'];

        $validated = $request->validate([
            'status' => ['required', Rule::in($statuses)],
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
            'action' => 'Complaint status updated',
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'note' => $validated['note'] ?? null,
        ]);

        return back()->with('success', 'Complaint status updated successfully.');
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
