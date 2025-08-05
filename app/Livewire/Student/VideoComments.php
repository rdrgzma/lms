<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class VideoComments extends Component
{
    public Video $video;
    public string $message = '';

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

        session()->flash('success', 'Comentário enviado com sucesso!');
    }

    public function render()
    {
        $comments = $this->video->comments()
            ->with('user', 'responder')
            ->latest()
            ->get();

        return view('livewire.student.video-comments', compact('comments'));
    }
}
