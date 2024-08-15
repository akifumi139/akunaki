<div class="mx-auto justify-center md:flex md:gap-6 md:p-4">
  @include('components.layouts.menu')
  <div class="max-w-lg flex-1">
    @auth
      <form class="mb-10 mt-20 w-full rounded-lg bg-white p-1 pt-2 md:mt-0" wire:submit.prevent="add" method="POST">
        @csrf
        <textarea
          class="mx-auto h-32 w-full rounded-b-lg rounded-tl-lg border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
          name="comment" placeholder="今、どんな？" wire:model="comment"></textarea>
        <div>
          <div class="mb-4 rounded-lg border-4 border-dashed p-6 text-center transition-all duration-200"
            x-data="{
                isDropping: false,
                handleDrop(event) {
                    let files = event.dataTransfer.files;
                    if (files.length > 0) {
                        let fileInput = document.getElementById('image');
                        fileInput.files = files;
                        fileInput.dispatchEvent(new Event('change'));
                    }
                }
            }" @dragover.prevent="isDropping = true" @dragleave.prevent="isDropping = false"
            @drop.prevent="isDropping = false; handleDrop($event)" @click="$refs.fileInput.click()"
            :class="{ 'border-blue-500 bg-blue-50': isDropping, 'border-gray-300': !isDropping }">
            <input class="hidden" id="image" type="file" wire:model="image" x-ref="fileInput">
            <p class="text-gray-500" x-show="!isDropping">ファイルを選択してください</p>
            <p class="text-blue-500" x-show="isDropping">ファイルをドロップしてください</p>
          </div>
          @error('image')
            <span class="error">{{ $message }}</span>
          @enderror
        </div>
        @if ($image)
          <div class="mb-4 flex justify-center">
            <img src="{{ $image->temporaryUrl() }}" alt="Image Preview" width="200">
          </div>
        @endif
        <div class="flex justify-end">
          <button class="rounded-xl bg-primary-600 px-4 py-1 text-white">書き込む</button>
        </div>
      </form>
    @endauth
    <div @class(['space-y-3', 'mt-20 md:mt-0' => !Auth::check()])>
      @foreach ($posts as $post)
        <div class="relative w-full rounded-lg bg-white px-3 py-1" x-data="{ open: false }">
          <div class="mb-2 flex cursor-pointer items-center justify-between text-2xl text-gray-600">
            <button @auth wire:click="pushPin({{ $post->id }})" @endauth>
              @if ($post->pin)
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
