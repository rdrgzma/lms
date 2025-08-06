<?php

namespace App\Filament\App\Pages;

use App\Models\Course;
use Filament\Pages\Page;

class MyCourse extends Page
{
    protected string $view = 'filament.app.pages.my-course';
    protected static ?string $slug = 'my-course';
    protected static ?string $title = 'Meus Cursos';

    public function getBreadcrumbs(): array
    {
            return [
                'title' => 'Meus Cursos',

            ];
    }


    protected static ?string $navigationLabel = 'Meus Cursos';

    public Course $course;
    public $myCourses = [];
    public function mount(): void
    {

        $this->myCourses = \Auth::user()->courses()->get();
    }
}
