<?php

namespace App\Filament\App\Resources\App\Courses;

use App\Filament\App\Resources\App\Courses\Pages\CreateCourse;
use App\Filament\App\Resources\App\Courses\Pages\EditCourse;
use App\Filament\App\Resources\App\Courses\Pages\ListCourses;
use App\Filament\App\Resources\App\Courses\Schemas\CourseForm;
use App\Filament\App\Resources\App\Courses\Tables\CoursesTable;
use App\Models\Course;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return CourseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CoursesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourses::route('/'),
            //'create' => CreateCourse::route('/create'),
           // 'edit' => EditCourse::route('/{record}/edit'),
        ];
    }
}
