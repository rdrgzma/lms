{{-- Lista de comentários --}}
<div class="mt-6">
    <h3 class="font-bold mb-2">Comentários</h3>

    @foreach($comments as $comment)
        <div class="mb-4 p-3 border rounded bg-gray-50">
            <div class="text-sm text-gray-700 font-semibold">{{ $comment->user->name }}</div>
            <div class="text-gray-800">{{ $comment->message }}</div>

            {{-- Botão responder --}}
            <button wire:click="$set('replyTo', {{ $comment->id }})"
                    class="text-xs text-blue-500 mt-1">Responder</button>

            {{-- Respostas --}}
            @foreach($comment->replies as $reply)
                <div class="ml-6 mt-2 p-2 border-l-2 border-gray-300">
                    <div class="text-sm text-gray-700 font-semibold">{{ $reply->user->name }}</div>
                    <div class="text-gray-800">{{ $reply->message }}</div>
                </div>
            @endforeach

            {{-- Formulário de resposta --}}
            @if(isset($replyTo) && $replyTo === $comment->id)
                <form wire:submit.prevent="sendMessage({{ $comment->id }})" class="flex gap-2 mt-2">
                    <input type="text" wire:model.defer="message" placeholder="Escreva sua resposta..."
                           class="w-full border rounded p-2 text-sm">
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">Enviar</button>
                </form>
            @endif
        </div>
    @endforeach
</div>

