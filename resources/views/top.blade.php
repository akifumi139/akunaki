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

<body class="h-screen flex">
  <div class="w-96">
    <form class="flex justify-center flex-col mx-6 p-2">
      <img class="w-36 mx-auto my-2" src="{{ asset('akunaki.svg') }}" alt="Icon">
      <div class="mb-4">
        <label class="" for="ログインID">
          <input
            class="shadow appearance-none border rounded w-full py-2 px-3 mt-1  leading-tight focus:outline-none focus:shadow-outline focus:bg-primary-100"
            id="username" type="text" placeholder="ログインID">
        </label>
      </div>
      <div class="mb-1">
        <label class="" for="パスワード">
          <input
            class="shadow appearance-none border rounded w-full mt-1 py-2 px-3 mb-3 leading-tight focus:outline-none focus:shadow-outline focus:bg-primary-100"
            id="password" type="password" placeholder="パスワード">
        </label>
      </div>
      <div class="flex items-center justify-between">
        <button
          class="bg-primary-600 mx-auto text-lg hover:bg-blue-600 text-white font-bold py-1 px-4 rounded-lg focus:outline-none focus:shadow-outline tracking-widest"
          type="button">
          GO!!
        </button>
      </div>
    </form>
  </div>
  <div class="w-full bg-primary-300"></div>
</body>

</html>
