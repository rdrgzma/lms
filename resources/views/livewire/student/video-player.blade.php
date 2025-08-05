<div>
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
    <div class="mt-1 text-sm text-gray-700">
        Progresso: {{ $progress }}%
    </div>

    {{-- Scripts para YouTube & Vimeo --}}
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

        // ===== YouTube Player =====
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

        // ===== Vimeo Player =====
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

