<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'title', 'description', 'video_url',
        'thumbnail', 'duration', 'order'
    ];
    protected $casts = [
        'duration' => 'integer',
        'order' => 'integer',
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function users() {
        return $this->belongsToMany(User::class)
            ->withPivot(['is_unlocked', 'has_started', 'has_finished', 'progress', 'started_at', 'finished_at'])
            ->withTimestamps();
    }
    public function authorizedUsers()
    {
        return $this->belongsToMany(User::class, 'video_user_access')
            ->withPivot('is_unlocked')
            ->withTimestamps();
    }


    public function comments() {
        return $this->hasMany(Comment::class);
    }
    /**
     * Accessor para gerar URL da thumbnail do YouTube
     */
    public function getThumbnailUrlAttribute() {
        // Se já tiver uma thumbnail salva no banco, usa ela
        if ($this->thumbnail) {
            return $this->thumbnail;
        }

        // Extrai o ID do vídeo do YouTube
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $this->video_url, $matches);
        $videoId = $matches[1] ?? null;

        if ($videoId) {
            return "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
        }

        return null;
    }

    // app/Models/Video.php
    public function getEmbedUrlAttribute()
    {
        $url = $this->video_url;

        // YouTube
        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $matches);
            $videoId = $matches[1] ?? null;
            if ($videoId) {
                return "https://www.youtube.com/embed/{$videoId}";
            }
        }

        // Vimeo
        if (str_contains($url, 'vimeo.com')) {
            preg_match('/vimeo\.com\/(?:video\/)?([0-9]+)/', $url, $matches);
            $videoId = $matches[1] ?? null;
            if ($videoId) {
                return "https://player.vimeo.com/video/{$videoId}";
            }
        }

        return null;
    }


}
