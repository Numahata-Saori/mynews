<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        
        {{--{{}}で囲まれたコードは、PHPで書かれた内容を表示するという意味、{{}}の中身を文字列に置換し、HTMLの中に記載する--}}
        {{--「@◯◯」という記載のところは、メソッドを読み込んでいる--}}
        
        {{--windowsの基本ブラウザであるedgeに対応するという記載--}}
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        {{--画面幅を小さくしたとき、たとえばスマートフォンで見たときなどに文字や画像の大きさを調整してくれるタグ--}}
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
         
        {{--CSRF「トークン」を認証済みのユーザーが、実装にアプリケーションに対してリクエストを送信しているのかを確認するために利用--}}
        {{--アプリケーションでHTMLフォームを定義する場合はいつでも、隠しCSRFトークンフィールドをフォームに埋め込み、CSRF保護ミドルウェアがリクエストの有効性をチェックできるようにしなければならない--}}
        {{--トークン隠しフィールドを生成するには、csrf_fieldヘルパ関数を使う--}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- 各ページごとにtitleタグを入れるために@yieldで空けておきます。 --}}
        {{--@yieldは指定したセッションの内容を表示するために使用--}}
        {{--コメントに書いてある通り、各ページごとにタイトルを変更できるようにするため--}}
        <title>@yield('title')</title>

        <!-- Scripts -->
        
        {{-- Laravel標準で用意されているJavascriptを読み込みます --}}
        {{--secure_asset(‘ファイルパス’)は、publicディレクトリのパスを返す関数のこと--}}
        <script src="{{ secure_asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
        <link href="{{ asset('css/front.css') }}" rel="stylesheet">
        
    </head>
    
    <body>
        <div id="app">
            {{-- 画面上部に表示するナビゲーションバーです。 --}}
            <nav class="navbar navbar-expand-md navbar-dark navbar-laravel">
                <div class="container">
                    
                    {{--url(“パス”)は、そのままURLを返すメソッド--}}
                    {{--これもsecure_assetと似たような関数で、configフォルダのapp.phpの中にあるnameにアクセス--}}
                    {{--基本的にはアプリケーションの名前「Laravel」が格納されている--}}
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            
                            {{-- 以下を追記 --}}
                        <!-- Authentication Links -->
                        {{-- ログインしていなかったらログイン画面へのリンクを表示 --}}
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        {{-- ログインしていたらユーザー名とログアウトボタンを表示 --}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                            {{-- 以上までを追記 --}}
                            
                        </ul>
                    </div>
                </div>
            </nav>
            {{-- ここまでナビゲーションバー --}}

            <main class="py-4">
                {{-- コンテンツをここに入れるため、@yieldで空けておきます。 --}}
                @yield('content')
            </main>
        </div>
    </body>
</html>