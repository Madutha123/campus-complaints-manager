<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    public function dashboard(): View
    {
        $userId = (int) auth()->id();

        $stats = [
            'total' => Complaint::query()->where('user_id', $userId)->count(),
            'pending' => Complaint::query()->where('user_id', $userId)->where('status', 'pending')->count(),
            'in_progress' => Complaint::query()->where('user_id', $userId)->where('status', 'in_progress')->count(),
            'resolved' => Complaint::query()->where('user_id', $userId)->where('status', 'resolved')->count(),
        ];

        $complaints = Complaint::query()
            ->where('user_id', $userId)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact('stats', 'complaints'));
    }

    public function index(Request $request): View
    {
        $status = $request->query('status');
        $statuses = ['pending', 'verified', 'assigned', 'in_progress', 'resolved', 'reopened', 'rejected', 'closed'];

        $complaints = Complaint::query()
            ->where('user_id', auth()->id())
            ->when($status, fn ($query) => $query->where('status', $status))
            ->with('category')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('student.complaints.index', compact('complaints', 'status', 'statuses'));
    }

    public function create(): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->with('department')
            ->orderBy('department_id')
            ->orderBy('name')
            ->get()
            ->groupBy(fn (Category $category) => $category->department?->name ?? 'Other');

        return view('student.complaints.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'description' => ['required', 'string', 'min:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'priority' => ['required', Rule::in(['low', 'medium', 'high', 'critical'])],
        ]);

        $category = Category::query()->findOrFail($validated['category_id']);

        $complaint = Complaint::query()->create([
            'user_id' => auth()->id(),
            'category_id' => $category->id,
            'department_id' => $category->department_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'] ?? null,
            'priority' => $validated['priority'],
            'status' => 'pending',
            'due_date' => now()->addHours((int) $category->sla_hours),
        ]);

        ActivityLog::query()->create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(),
            'action' => 'Complaint submitted',
            'old_status' => null,
            'new_status' => 'pending',
            'note' => 'Complaint submitted by student.',
        ]);

        return redirect()->route('student.complaints.index')->with('success', 'Complaint submitted successfully.');
    }

    public function show(Complaint $complaint): View
    {
        Gate::authorize('view', $complaint);

        $complaint->load([
            'category',
            'department',
            'assignedTo',
            'comments' => fn ($query) => $query->publicComments()->with('user', 'attachments')->latest(),
            'attachments',
            'activityLogs' => fn ($query) => $query->with('user')->latest(),
        ]);

        return view('student.complaints.show', compact('complaint'));
    }
}
