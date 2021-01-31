<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'color',
        'meta_data',
    ];

    public function scorecards(){
        return $this->hasMany(Scorecard::class);
    }
}
