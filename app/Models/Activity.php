<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'changes' => 'array',
    ];

    /**
     * project Relationship.
     */
    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }
}
