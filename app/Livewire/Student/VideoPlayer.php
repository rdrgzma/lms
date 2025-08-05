<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VideoPlayer extends Component
{
    public Video $video;
    public int $progress = 0; // porcentagem assistida

    public function mount(Video $video)
    {
        $this->video = $video;

        // Se o vídeo não estiver liberado para o aluno, bloquear
        $pivot = $this->video->users()->where('user_id', Auth::id())->first();
        if (!$pivot || !$pivot->pivot->is_unlocked) {
            abort(403, 'Vídeo não liberado');
        }

        // Marcar como iniciado se ainda não estiver
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
    public function render()
    {
        return view('livewire.student.video-player');
    }
}
