<div class="mx-auto justify-center md:flex md:gap-6 md:p-4">
  @include('components.layouts.menu')
  <div class="max-w-lg flex-1">
    <div @class(['space-y-3', 'mt-20 md:mt-0' => !Auth::check()])>
      @foreach ($posts as $post)
        <div class="relative w-full rounded-lg bg-white px-3 py-1" x-data="{ open: false }">
          <div class="mb-2 flex cursor-pointer items-center justify-between text-2xl text-gray-600">
            <button @auth wire:click="pushPin({{ $post->id }})" @endauth>
              @if ($post->pin->status)
                <i class="fa-solid fa-thumbtack -rotate-12 transform text-primary-600"></i>
              @else
                <i class="fa-solid fa-thumbtack text-gray-300"></i>
              @endif
            </button>
            @auth
              <button class="flex items-center rounded p-2 text-gray-500 hover:bg-gray-100" @click="open = !open">
                <i class="fas fa-ellipsis-h"></i>
              </button>
            @endauth
          </div>
          <div class="mt-2" x-show="open">
            <div class="flex flex-col space-y-2">
              <button class="rounded bg-red-500 px-4 py-2 text-white hover:bg-red-600"
                wire:click="delete({{ $post->id }})" @click="open = !open">
                削除する
              </button>
            </div>
          </div>
          <div class="mt-2 text-gray-900">
            {{ $post->comment }}
          </div>
          @if ($post->imagePath)
            <div class="mb-4 mt-3 flex justify-center">
              <img class="h-auto rounded" src="{{ asset('storage/' . $post->imagePath) }}">
            </div>
          @endif
          <div class="mt-4 flex justify-end text-sm text-gray-500">
            {{ $post->updated_at->format('Y/m/d H:i') }}
          </div>
        </div>
      @endforeach
    </div>
    <div class="flex justify-center pb-0 pt-6">
      @if ($posts->hasMorePages())
        <button class="h-12 w-48 rounded-t-full bg-primary-600 pt-4 text-center text-lg text-white"
          wire:click="loadMore" wire:loading.attr="disabled">
          続きを読む
        </button>
      @endif
    </div>
    <div wire:loading>
      Loading...
    </div>
  </div>
</div>
