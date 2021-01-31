<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scorecard extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'score_type',
        'meta_data',
        'score',
        'course_id',
        'category_id',
        'golfer_id',
    ];

    public function golfer()
    {
        return $this->belongsTo(User::class, 'golfer_id', 'id');
    }

    public function course()
    {
        return $this->hasOne(Course::class, $foreignKey = 'course_id', $localKey = 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->with(['golfer']);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}