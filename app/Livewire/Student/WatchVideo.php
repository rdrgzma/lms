<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WatchVideo extends Component
{
    public Video $video;
    public int $progress = 0;
    public string $message = '';

    public function mount(Video $video)
    {
        $this->video = $video;

        // Bloqueio se não tiver acesso
        $pivot = $this->video->users()->where('user_id', Auth::id())->first();
        if (!$pivot || !$pivot->pivot->is_unlocked) {
            abort(403, 'Vídeo não liberado.');
        }

        // Marca início
        if (!$pivot->pivot->has_started) {
            $this->video->users()->updateExistingPivot(Auth::id(), [
                'has_started' => true,
                'started_at' => Carbon::now()
            ]);
        }
    }

    public function updateProgress($percent)
    {
        if ($percent > $this->progress) {
            $this->progress = $percent;

            $this->video->users()->updateExistingPivot(Auth::id(), [
                'progress' => $percent
            ]);

            if ($percent >= 100) {
                $this->video->users()->updateExistingPivot(Auth::id(), [
                    'has_finished' => true,
                    'finished_at' => Carbon::now()
                ]);
            }
        }
    }

    public function addComment()
    {
        $this->validate([
            'message' => 'required|string|min:3'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'video_id' => $this->video->id,
            'message' => $this->message
        ]);

        $this->reset('message');
    }

    public function render()
    {
        $comments = $this->video->comments()
            ->with('user')
            ->latest()
            ->get();

        return view('livewire.student.watch-video', compact('comments'));
    }
}

