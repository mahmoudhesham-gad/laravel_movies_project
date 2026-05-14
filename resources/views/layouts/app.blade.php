@include('layouts.header')

    {{--
        Every child view calls:
            @extends('layouts.app')
            @section('content') ... @endsection

        Optional slots:
            @section('title', 'Page Title')          — sets <title>
            @push('head') <link ...> @endpush         — extra CSS/meta in <head>
            @push('scripts') <script ...> @endpush    — extra JS before </body>
    --}}
    @yield('content')

@include('layouts.footer')
