<!doctype html>
<html>
    <head>
        <base href="{{ asset('/') }}" />      
        @include('admin.includes.meta')
        @include('admin.includes.css')
        @include('admin.includes.scripts')
    </head>

    <body class="main">

        <?php if (Auth::check()): ?>
            <div class="menu-left">
                @include('admin.includes.menu') 
            </div>

            <div class="panel-view">
                <div class="container-fluid">
                    @include('messages.alert') 
                    @yield('content')
                </div> 
            </div> 
        <?php else: ?> 
            <div class="container-fluid" style="height:100%;">
                @include('messages.alert') 
                @yield('content')
            </div>
        <?php endif; ?>
    </body>
</html>


