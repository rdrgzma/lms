<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('video_id')
                    ->required()
                    ->numeric(),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('response')
                    ->columnSpanFull(),
                TextInput::make('responded_by')
                    ->numeric(),
            ]);
    }
}
