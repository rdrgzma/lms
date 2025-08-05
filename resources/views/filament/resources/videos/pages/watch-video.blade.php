<x-filament::page>

    <h2 class="text-xl font-bold mb-4">{{ $video->title }}</h2>

    @if($video->embed_url)
        <div style="position: relative; padding-bottom: 56.25%; height: 0;">
            <iframe
                src="{{ $video->embed_url }}?autoplay=0"
                frameborder="0"
                allowfullscreen
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                style="position: absolute; top:0; left:0; width:100%; height:100%;">
            </iframe>
        </div>
    @else
        <p class="text-red-500">Nenhuma URL de vídeo configurada.</p>
    @endif

    <div class="mt-4">
        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-200 rounded">
            Voltar para lista
        </a>
    </div>
</x-filament::page>

