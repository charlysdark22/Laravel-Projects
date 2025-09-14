<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    protected $fillable = ['title', 'is_done'];

    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class, 'task_keyword', 'task_id', 'keyword_id');
    }
}