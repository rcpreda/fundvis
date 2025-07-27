<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;

class Task extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $fillable = [
        'name',
        'description',
        'status',
        'taskable_id',
        'taskable_type',
        'user_id'
    ];

    public $translatable = ['name', 'description'];

    public function taskable(): MorphTo
    {
        return $this->morphTo();
    }

    public function subtasks(): MorphMany
    {
        return $this->morphMany(Task::class, 'taskable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
