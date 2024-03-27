<!DOCTYPE html>
<html lang="en">
    <head>
       @include('book::layouts.head-tag')
        @yield('head-tag')
    </head>
    <body>
    <div id="app">

        <main class="py-4">
            @yield('content')
        </main>

    </div>

    @include('sweetalert::alert')


    @include('book::layouts.script')
        @yield('script')
    </body>
</html>
