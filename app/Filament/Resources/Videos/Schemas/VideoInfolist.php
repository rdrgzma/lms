<?php

namespace App\Filament\Resources\Videos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;

class VideoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                ImageEntry::make('thumbnail_url')
                    ->label('Thumbnail'),
                TextEntry::make('video_url'),
                TextEntry::make('duration')
                    ->numeric(),
                TextEntry::make('order')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime('d/m/Y H:i:s'),
                TextEntry::make('updated_at')
                    ->dateTime('d/m/Y H:i:s'),
            ]);
    }
}
