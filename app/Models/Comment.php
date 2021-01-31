<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'meta_data',
        'golfer_id',
        'score_id',
    ];

    public function golfer(){
        return $this->belongsTo(User::class, 'golfer_id', 'id');
    }

    public function score(){
        return $this->belongsTo(Scorecard::class);
    }
}
