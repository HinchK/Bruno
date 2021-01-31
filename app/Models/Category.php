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

    public function scores(){
        return $this->hasMany(Scorecard::class);
    }
}
