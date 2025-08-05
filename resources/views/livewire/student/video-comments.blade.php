<div class="mt-6">
    <h3 class="font-bold text-lg mb-2">Comentários</h3>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-2">
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulário de novo comentário --}}
    <form wire:submit.prevent="addComment" class="mb-4">
        <textarea wire:model.defer="message" class="w-full border rounded p-2" rows="3" placeholder="Escreva seu comentário..."></textarea>
        @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Enviar</button>
    </form>

    {{-- Lista de comentários --}}
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

