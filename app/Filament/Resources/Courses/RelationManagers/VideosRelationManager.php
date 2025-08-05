<?php

namespace App\Filament\Resources\Courses\RelationManagers;

use App\Filament\Resources\Videos\VideoResource;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Schemas\Schema;

class VideosRelationManager extends RelationManager
{
    protected static string $relationship = 'Videos';

    protected static ?string $relatedResource = VideoResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('video_url')
                    ->required(),
                TextInput::make('thumbnail'),
                TextInput::make('duration')
                    ->numeric(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
