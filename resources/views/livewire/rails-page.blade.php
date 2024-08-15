<div class="mx-auto justify-center md:flex md:gap-6 md:p-4">
  @include('components.layouts.menu')
  <div class="max-w-lg flex-1">
    <div @class(['space-y-3', 'mt-20 md:mt-0' => !Auth::check()])>
      <div class="text-center text-lg font-bold text-secondary">
        鋭意作成中です！！
      </div>
    </div>
  </div>
</div>
