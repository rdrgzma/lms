<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'title', 'description'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function videos() {
        return $this->hasMany(Video::class);
    }
}
