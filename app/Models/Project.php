<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable   = [
        'title',
        'description',
        'user_id',
    ];

    /**
     * user Relationship.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
