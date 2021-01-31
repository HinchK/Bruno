<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'par',
        ];

    public function scorecards(){
        return $this->belongsToMany(Scorecard::class);
    }
}
