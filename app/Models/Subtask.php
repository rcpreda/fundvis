<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'task_id', 'status'];

    public $translatable = ['name', 'description'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
