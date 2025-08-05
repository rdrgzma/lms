<?php

namespace App\Filament\Resources\Videos\Pages;

use App\Filament\Resources\Videos\VideoResource;
use App\Models\Video;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class WatchVideo extends Page
{
    use InteractsWithRecord;


    protected static string $resource = VideoResource::class;
    public static function getNavigationLabel(): string
    {
        return 'Assistir vídeo';
    }

    protected string $view = 'filament.resources.videos.pages.watch-video';
    public Video $video;

    public function mount($record): void
    {
//dd($record);
$this->video = Video::find($record);
    }
    public function getRecord(): \App\Models\Video
    {
        return \App\Models\Video::findOrFail($this->record);
    }
}
