<?php

namespace App\Models;

use App\Models\Project;
use App\Models\Activity;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, RecordsActivity;

    protected $guarded = [];

    protected $touches = ['project'];

    public static $recordableEvents = ['created', 'deleted'];

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function activities() : MorphMany
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function completed()
    {
        $this->update([
            'completed' => true,
        ]);
        $this->recordActivity('task_completed');
    }

    public function inComplete()
    {
        $this->update([
            'completed' => false,
        ]);
        $this->recordActivity('task_inComplete');
    }
}
