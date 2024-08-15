<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'あくなき' }}</title>
  @vite(['resources/css/app.css'])
  <link type="image/svg+xml" href="/akunaki.svg" rel="icon" sizes="any">
</head>

<body class="h-screen bg-primary-100">
  {{ $slot }}
</body>

</html>
