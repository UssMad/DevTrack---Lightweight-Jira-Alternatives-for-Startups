<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Task extends Model
{
    protected $table = 'taskes'; // matches migration typo

    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    /**
     * Human-readable status label.
     */
    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn () => match ($this->status) {
            'todo'        => 'À faire',
            'in_progress' => 'En cours',
            'done'        => 'Terminé',
            default       => ucfirst($this->status),
        });
    }

    /**
     * Deadline urgency indicator.
     */
    protected function deadlineStatus(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->deadline) {
                return 'none';
            }

            $hoursLeft = now()->diffInHours($this->deadline, false);

            if ($this->status === 'done') {
                return 'done';
            }

            if ($hoursLeft < 0) {
                return 'overdue';
            }

            if ($hoursLeft <= 48) {
                return 'urgent';
            }

            return 'normal';
        });
    }

    // ─── Local Scopes ─────────────────────────────────────────────────────────

    /**
     * Scope: tasks due within 48 hours and not yet done.
     */
    public function scopeUrgent(Builder $query): Builder
    {
        return $query->where('status', '!=', 'done')
                     ->where('deadline', '<=', now()->addHours(48));
    }
}
