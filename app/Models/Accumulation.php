<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accumulation extends Model
{
    use HasFactory;

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function subjectmatter()
    {
        return $this->belongsTo(Subjectmatter::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
