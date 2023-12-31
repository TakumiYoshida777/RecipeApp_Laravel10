<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/css/color.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if (isset($script))
        {{ $script }}
    @endif
</head>

<body class="font-sans antialiased background-color">
    <div class="min-h-screen">
        {{-- ここに共通のヘッダーコンポーネントを読み込む --}}
        @include('layouts.announce-header')
        @include('layouts.global-header')
        @if (flash()->message)
        <div class="bg-blue-500 text-white font-bold px-4 py-2 rounded">

            {{ flash()->message }}

        </div>
        @endif
        @if ($errors->any())
        <div class="bg-red-500 text-white font-bold px-4 py-2 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="container mx-auto pt-8">
            {{ $slot }}
        </main>
        {{-- LaravelのBladeテンプレートエンジンでは、{{ $slot }}は親ビュー（この場合はapp.blade.php）で子ビュー（この場合はdashboard.blade.php）の内容を表示するためのプレースホルダーとして機能します。

            dashboard.blade.phpの内容は、app.blade.phpの{{ $slot }}に挿入されます。これは、x-slotタグを使用せずとも可能です。x-slotは、名前付きスロットを定義するためのもので、特定の部分に特定のビューを挿入するために使用されます。

            したがって、You're logged in!メッセージはdashboard.blade.phpからapp.blade.phpの{{ $slot }}に挿入され、結果として表示されます。 --}}
    </div>

    @include('layouts.footer')
</body>

</html>
