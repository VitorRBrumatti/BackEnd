<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;
    protected $fillable = [
        'title_subtask',
        'description_subtask',
        'task_id',
        'status_subtask',
    ];

    public function Task() {
        return $this->belongsTo(Task::class);
    }
}
