<div class="max-w-5xl mx-auto">
    {{-- Player --}}
    <div class="aspect-w-16 aspect-h-9">
        <iframe
            id="videoPlayer"
            src="{{ $video->embed_url }}?autoplay=0&enablejsapi=1&playsinline=1"
            frameborder="0"
            allowfullscreen
            allow="autoplay; fullscreen; picture-in-picture; encrypted-media">
        </iframe>
    </div>

    {{-- Barra de progresso --}}
    <div class="w-full bg-gray-200 h-2 mt-2 rounded-full overflow-hidden">
        <div class="bg-green-500 h-full transition-all duration-500" style="width: {{ $progress }}%"></div>
    </div>
    <div class="mt-1 text-sm text-gray-700">Progresso: {{ $progress }}%</div>

    {{-- Comentários --}}
    <div class="mt-6">
        <h3 class="font-bold text-lg mb-2">Comentários</h3>

        <form wire:submit.prevent="addComment" class="mb-4">
            <textarea wire:model.defer="message" class="w-full border rounded p-2" rows="3" placeholder="Escreva seu comentário..."></textarea>
            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Enviar</button>
        </form>

        @foreach($comments as $comment)
            <div class="border-b py-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">{{ $comment->user->name }}</span>
                    <span class="text-xs text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <p class="text-gray-800">{{ $comment->message }}</p>
                @if($comment->response)
                    <div class="bg-gray-100 p-2 rounded mt-1 text-sm text-gray-700">
                        <strong>Resposta do professor:</strong> {{ $comment->response }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Scripts YouTube & Vimeo --}}
    <script>
        const url = @json($video->video_url);
        let lastPercent = 0;

        function updateProgress(percent) {
            percent = Math.floor(percent);
            if (percent !== lastPercent) {
                lastPercent = percent;
                $wire.updateProgress(percent);
            }
        }

        // YouTube
        if (url.includes('youtube.com') || url.includes('youtu.be')) {
            let ytPlayer;
            function onYouTubeIframeAPIReady() {
                ytPlayer = new YT.Player('videoPlayer', {
                    events: {
                        'onStateChange': function (event) {
                            if (event.data === YT.PlayerState.PLAYING) {
                                let duration = ytPlayer.getDuration();
                                setInterval(() => {
                                    let current = ytPlayer.getCurrentTime();
                                    updateProgress((current / duration) * 100);
                                }, 5000);
                            }
                        }
                    }
                });
            }
            let tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            document.body.appendChild(tag);
        }

        // Vimeo
        if (url.includes('vimeo.com')) {
            let script = document.createElement('script');
            script.src = "https://player.vimeo.com/api/player.js";
            script.onload = function () {
                const player = new Vimeo.Player(document.getElementById('videoPlayer'));
                player.getDuration().then(duration => {
                    player.on('timeupdate', function (data) {
                        updateProgress((data.seconds / duration) * 100);
                    });
                });
            };
            document.body.appendChild(script);
        }
    </script>
</div>

