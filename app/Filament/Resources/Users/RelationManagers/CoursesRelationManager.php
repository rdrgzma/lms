<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Courses\CourseResource;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    //protected static ?string $relatedResource = CourseResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->options(fn () => \App\Models\User::query()->pluck('title', 'id'))
                    ->preload()
                    ->searchable()
                    ->required()
                    ->label(__('Select Course')),


            ]);
    }

    public function table(Table $table): Table
    {

            return $table
                ->modelLabel('Curso')
                ->pluralModelLabel('Cursos')
                ->recordTitleAttribute('title')
                ->columns([
                    TextColumn::make('title')
                        ->searchable(),

                ])
                ->filters([
                    //
                ])
                ->headerActions([
                    AttachAction::make('Attach User')
                        ->icon('heroicon-s-user-plus')
                        ->label('Liberar acesso')
                        ->preloadRecordSelect()
                ])
                ->recordActions([

                    DetachAction::make()
                        ->icon('heroicon-s-hand-thumb-down')
                        ->label('Remover acesso'),
                ])
                ->toolbarActions([
                    BulkActionGroup::make([
                        DetachBulkAction::make(),

                    ]),
                ]);
    }

}
