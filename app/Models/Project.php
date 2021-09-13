<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Activity;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, RecordsActivity;

    protected $guarded = [];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks() : HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function activities() : HasMany
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function addTask($body)
    {
        return $this->tasks()->create(['body' => $body]);
    }

}
