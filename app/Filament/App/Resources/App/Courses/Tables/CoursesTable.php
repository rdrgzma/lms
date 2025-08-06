<?php

namespace App\Filament\App\Resources\App\Courses\Tables;

use App\Models\Course;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                 TextColumn::make('title')->searchable(),
                TextColumn::make('description')->limit(50),
            ])
            ->filters([

            ])
            ->recordActions([

            ])
            ->toolbarActions([


            ]);
    }


}
