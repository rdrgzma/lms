<?php
// routes/web.php
use App\Livewire\Student\VideoPlayer;

Route::middleware(['auth'])->group(function () {
  //  Route::get('/videos/{video}', VideoPlayer::class)->name('student.video');
    Route::get('/videos/{video}', \App\Livewire\Student\WatchVideo::class)->name('student.watch');
    Route::get('/aluno/curso/{course}/{video?}', \App\Livewire\Student\CoursePlayer::class)
        ->name('student.course.player');
});

