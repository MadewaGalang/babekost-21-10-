<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'agenda_date', 'description',
        'documentation_path', 'status',
    ];

    protected function casts(): array
    {
        return ['agenda_date' => 'date'];
    }
}