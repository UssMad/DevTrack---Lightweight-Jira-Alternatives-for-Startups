<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Task;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'deadline'
    ];

   public function users()
{
    return $this->belongsToMany(User::class, 'user_project')
        ->withPivot('role');
}
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}