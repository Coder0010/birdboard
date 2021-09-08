<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $touches = ['project'];

    /**
     * project Relationship.
     */
    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
