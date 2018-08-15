<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Must -->
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Description">
    <meta name="keywords" content="Keywords">
    <!-- Android  -->
    <meta name="theme-color" content="#fff">
    <meta name="mobile-web-app-capable" content="yes">
    <!-- iOS -->
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- Windows  -->
    <meta name="msapplication-navbutton-color" content="#fff">
    <meta name="msapplication-TileColor" content="#fff">
    <meta name="msapplication-TileImage" content="/img/logo.png"><!-- 144 -->
    <meta name="msapplication-config" content="browserconfig.xml">
    <!-- Pinned Sites  -->
    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="msapplication-tooltip" content="{{ config('app.name') }}">
    <meta name="msapplication-starturl" content="/">
    <!-- Tap highlighting  -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- UC Mobile Browser  -->
    <meta name="full-screen" content="yes">
    <meta name="browsermode" content="application">
    <!-- Disable night mode for this page  -->
    <meta name="nightmode" content="enable/disable">
    <!-- Fitscreen  -->
    <!-- <meta name="viewport" content="uc-fitscreen=yes"/> -->
    <!-- Layout mode -->
    <meta name="layoutmode" content="fitscreen/standard">
    <!-- imagemode - show image even in text only mode  -->
    <meta name="imagemode" content="force">
    <!-- Orientation  -->
    <meta name="screen-orientation" content="portrait">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Main Link Tags  -->
    <link href="/img/logo.png" rel="icon" type="image/png" sizes="16x16">
    <link href="/img/logo.png" rel="icon" type="image/png" sizes="32x32">
    <link href="/img/logo.png" rel="icon" type="image/png" sizes="48x48">
    <!-- iOS  -->
    <link href="/img/logo.png" rel="apple-touch-icon">
    <link href="/img/logo.png" rel="apple-touch-icon" sizes="76x76">
    <link href="/img/logo.png" rel="apple-touch-icon" sizes="120x120">
    <link href="/img/logo.png" rel="apple-touch-icon" sizes="152x152">
    <!-- Startup Image  -->
    <link href="/img/logo.png" rel="apple-touch-startup-image"><!-- 320x480 -->
    <!-- Pinned Tab  -->
    <!-- <link href="path/to/icon.svg" rel="mask-icon" size="any" color="red"> -->
    <!-- Android  -->
    <link href="/img/logo.png" rel="icon" sizes="192x192">
    <link href="/img/logo.png" rel="icon" sizes="128x128">
    <!-- Others -->
    <!-- <link href="favicon.icon" rel="shortcut icon" type="image/x-icon"> -->
    <!-- UC Browser  -->
    <link href="/img/logo.png" rel="apple-touch-icon-precomposed" sizes="52x52">
    <link href="/img/logo.png" rel="apple-touch-icon" sizes="72x72">
    <!-- Manifest.json  -->
    <link href="/manifest.json" rel="manifest">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="mdc-typography">
    <div id="app">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ session('status') }}
            </div>
        @endif
        @auth
            <nav id="nav-primary">
                <div class="btn-group btn-group-justified" role="group">
                    <div class="btn-group dropup" role="group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menu <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('events') }}">Événements</a></li>
                            <li><a href="{{ route('clubs') }}">Clubs</a></li>
                            <li><a href="{{ route('notifications') }}">Notifications</a></li>
                            <li><a href="{{ route('account.informations') }}">Mon profil</a></li>
                            <li><a href="{{ route('account.subscriptions') }}">Mes abonnements</a></li>
                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                            <li><a href="#">Site web</a></li>
                        </ul>
                    </div>
                    <div class="btn-group" role="group">
                        <a class="btn btn-default" href="{{ route('events') }}">Événements</a>
                    </div>
                    <div class="btn-group" role="group">
                        <a class="btn btn-default" href="{{ route('clubs') }}">Clubs</a>
                    </div>
                    <div class="btn-group" role="group">
                        <a class="btn btn-default" href="{{ route('notifications') }}">Notifications</a>
                    </div>
                </div>
            </nav>
        @endauth
            
        @yield('content')
        
        @if (Auth::user())
            <push-component
                user-id="{{ Auth::user()->id }}"
                push-subscription-endpoints="{{ json_encode(Auth::user()->pushSubscriptions->pluck('endpoint')->toArray()) }}">
            </push-component>
        @endif

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
