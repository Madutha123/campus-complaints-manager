<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['complaint_id', 'comment_id', 'file_name', 'file_path', 'file_type', 'file_size_kb'])]
class Attachment extends Model
{
    use HasFactory;

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(ComplaintComment::class, 'comment_id');
    }
}