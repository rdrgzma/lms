<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'video_id', 'message', 'response', 'responded_by'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function video() {
        return $this->belongsTo(Video::class);
    }

    public function responder() {
        return $this->belongsTo(User::class, 'responded_by');
    }
}
