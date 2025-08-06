<?php

namespace App\Filament\App\Resources\App\Courses\Pages;

use App\Filament\App\Resources\App\Courses\CourseResource;
use App\Models\Course;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
          //  CreateAction::make(),
        ];
    }

}
