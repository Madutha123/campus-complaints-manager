<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'ticket_no',
    'user_id',
    'category_id',
    'department_id',
    'assigned_to',
    'title',
    'description',
    'location',
    'status',
    'priority',
    'due_date',
    'resolved_at',
])]
class Complaint extends Model
{
    use HasFactory;

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Complaint $complaint): void {
            if (! $complaint->ticket_no) {
                $nextId = static::max('id') + 1;
                $complaint->ticket_no = 'CMP-'.str_pad((string) $nextId, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function complaintComments(): HasMany
    {
        return $this->hasMany(ComplaintComment::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function feedback(): HasOne
    {
        return $this->hasOne(Feedback::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }
}