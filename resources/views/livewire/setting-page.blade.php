<div class="mx-auto justify-center md:flex md:gap-6 md:p-4">
  @include('components.layouts.menu')
  <div class="max-w-lg flex-1">
    <div @class(['space-y-3', 'mt-20 md:mt-0' => !Auth::check()])>
      <div class="relative w-full rounded-lg bg-white px-3 py-1">

        <div class="mt-2">
          スマホアプリ<br>ログイン用のQRコード
        </div>
        <div class="text-cente max-w-48 mx-auto my-4 flex flex-col justify-center space-y-4">
          @if ($qrCodeImage)
            <img src="{{ $qrCodeImage }}" alt="QRコード">
            <button
              class="rounded-lg bg-blue-400 px-6 py-3 font-semibold text-white shadow-md transition duration-300 ease-in-out hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
              wire:click="makeQRCode">
              再生成する
            </button>
          @else
            <button
              class="rounded-lg bg-secondary px-6 py-3 font-semibold text-white shadow-md transition duration-300 ease-in-out hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
              wire:click="makeQRCode">
              生成する
            </button>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
