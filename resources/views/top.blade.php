<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>進捗管理</title>
  @vite(['resources/css/app.css'])
  <link type="image/svg+xml" href="/akunaki.svg" rel="icon" sizes="any">
</head>

<body class="flex h-screen">
  <div class="w-96">
    <form class="mx-6 flex flex-col justify-center p-2">
      <img class="mx-auto my-2 w-36" src="{{ asset('akunaki.svg') }}" alt="Icon">
      <div class="mb-4">
        <label class="" for="ログインID">
          <input
            class="focus:shadow-outline mt-1 w-full appearance-none rounded border px-3 py-2 leading-tight shadow focus:bg-primary-100 focus:outline-none"
            id="username" type="text" placeholder="ログインID">
        </label>
      </div>
      <div class="mb-1">
        <label class="" for="パスワード">
          <input
            class="focus:shadow-outline mb-3 mt-1 w-full appearance-none rounded border px-3 py-2 leading-tight shadow focus:bg-primary-100 focus:outline-none"
            id="password" type="password" placeholder="パスワード">
        </label>
      </div>
      <div class="flex items-center justify-between">
        <button
          class="focus:shadow-outline mx-auto rounded-lg bg-primary-600 px-4 py-1 text-lg font-bold tracking-widest text-white hover:bg-blue-600 focus:outline-none"
          type="button">
          GO!!
        </button>
      </div>
    </form>
  </div>
  <div class="min-h-screen w-full overflow-auto bg-primary-300 p-3">
    <div class="max-w-[680px]">
      <form class="min-h-32 mx-12 mb-12" action="{{ route('card.store') }}" method="POST">
        @csrf
        <textarea
          class="mx-auto h-40 w-full rounded-b-lg rounded-tl-lg border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
          name="comment" placeholder="何か書け"></textarea>
        <div class="flex justify-end">
          <button class="rounded-xl bg-primary-600 px-4 py-1 text-white">送信する</button>
        </div>
      </form>
      <hr class="mt-10 border-2 border-primary-600">
      <div class="md:max-w-72 mx-auto -mb-3 -mt-6 flex h-10 w-1/2 justify-between md:-mt-8 md:h-14">
        <div
          class="-ms-3 flex w-10 items-center justify-center rounded-full bg-secondary text-lg text-gray-300 md:-ms-4 md:w-14 md:text-3xl">
          ●
        </div>
        <div
          class="-me-3 flex w-10 items-center justify-center rounded-full bg-secondary text-lg text-gray-300 md:-me-4 md:w-14 md:text-3xl">
          ●
        </div>
      </div>

      @foreach ($posts as $post)
        <div class="md:max-w-72 mx-auto flex h-6 w-1/2 justify-between">
          <div class="w-4 bg-secondary md:w-6"> </div>
          <div class="w-4 bg-secondary md:w-6"> </div>
        </div>
        <div class="rounded-lg border-2 border-gray-300 bg-white p-2 md:mx-12">
          <div class="flex">
            <img class="mr-4 h-12 w-12 rounded-full" src="{{ asset('akunaki.svg') }}">
            <div class="w-full">
              <div class="flex justify-between">
                <span class="block text-sm font-bold">{{ $post->user->name }}</span>
                <span class="-mt-1 ml-2 block text-gray-700"> {{ $post->updated_at->format('Y/m/d H:i') }}</span>
              </div>
              <p class="py-1 text-gray-800">{{ $post->comment }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
</body>

</html>
