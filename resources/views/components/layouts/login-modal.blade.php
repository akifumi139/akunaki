<img src="{{ asset('akunaki.svg') }}" alt="Icon" wire:click="clickIcon" @class([
    'mx-auto md:mb-4 h-16 ml-2 md:h-24 md:w-24 transform',
    'rotate-16' => $this->iconRotateNo == 1,
    'rotate-40' => $this->iconRotateNo == 2,
    'rotate-90' => $this->iconRotateNo >= 3 || Auth::check(),
])>

@if ($isLoginModal)
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-500 bg-opacity-75">
    <div class="relative mx-auto w-72 max-w-sm rounded-lg bg-white px-6 py-3">
      <button class="absolute right-2 top-2 text-gray-600 hover:text-gray-900 focus:outline-none"
        wire:click="closeLoginModal">
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <h2 class="mb-4 text-2xl font-bold text-primary-600">準備はいい?</h2>
      <form class="flex flex-col gap-5" wire:submit.prevent="login">
        <label class="text-sm font-medium text-gray-600" for="name">
          ID
          <input
            class="mt-1 w-full rounded-md border border-gray-300 p-1 ps-1 text-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            id="name" name="name" type="text" wire:model.lazy="name">
        </label>

        <label class="text-sm font-medium text-gray-600" for="password">
          パスワード
          <input
            class="mt-1 block w-full rounded-md border border-gray-300 p-1 ps-1 text-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            id="password" name="password" type="password" wire:model.lazy="password">
        </label>

        <div class="flex justify-center">
          <button
            class="w-4/5 rounded-md bg-primary-600 px-4 py-2 text-white hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-600"
            type="submit">
            OK!!
          </button>
        </div>
      </form>
    </div>
  </div>
@endif
