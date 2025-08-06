<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Video;
use App\Models\Course;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CoursePlayer extends Component
{
    public Course $course;
    public Video $currentVideo;
    public string $message = '';

    protected $listeners = ['updateProgress' => 'updateProgress'];

    public function mount(Course $course, Video $video = null)
    {
        $user = Auth::user();

        $this->course = $course;

        $query = $course->videos()
            ->whereHas('authorizedUsers', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->where('is_unlocked', true);
            })
            ->orderBy('order');

        $this->currentVideo = $video
            ? $query->findOrFail($video->id)
            : $query->firstOrFail();
    }


    public function selectVideo($videoId)
    {
        $this->currentVideo = $this->course->videos()->findOrFail($videoId);
    }

    public function sendMessage($parentId = null)
    {
        $this->validate(['message' => 'required|min:3']);

        Comment::create([
            'user_id' => Auth::id(),
            'video_id' => $this->currentVideo->id,
            'message' => $this->message,
            'parent_id' => $parentId
        ]);

        $this->reset('message');
        session()->flash('success', 'Comentário enviado com sucesso!');
    }


    public function updateProgress($videoId, $progress)
    {
        $progress = min(100, max(0, (int) $progress));

        $this->course->videos()->updateExistingPivot($videoId, [
            'progress' => $progress,
            'has_started' => true,
            'started_at' => now(),
            'has_finished' => $progress >= 95,
            'finished_at' => $progress >= 95 ? now() : null,
        ]);

        $this->dispatch('$refresh');
    }

    public function render()
    {
        $videos = $this->course->videos()
            ->whereHas('authorizedUsers', function ($q) {
                $q->where('user_id', Auth::id())
                    ->where('is_unlocked', true);
            })
            ->withPivot(['has_finished', 'progress'])
            ->orderBy('order')
            ->get();

        $comments = Comment::where('video_id', $this->currentVideo->id)
            ->whereNull('parent_id')
            ->with('replies.user', 'user')
            ->latest()
            ->get();

        return view('livewire.student.course-player', [
            'videos' => $videos,
            'comments' => $comments
        ]);
    }
}

