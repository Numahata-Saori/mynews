{{--テンプレート（viewファイル）の継承（読み込み）をおこなうメソッド--}}
@extends('layouts.front')

{{--@sectionは、名前が示す通りにコンテンツのセクションを定義--}}
@section('content')
<h1>NEWSサイト</h1>
    <div class="container">
        <hr color="#c0c0c0">
        
        {{--is_nullというメソッドは、「nullであればtrue、それ以外であればfalseを返す」というメソッド--}}
        {{--「!」は否定演算子と呼ばれ、「true、falseを反転する」という意味--}}
        {{--@if !is_null($headline)は、$headlineが空なら飛ばして（実行しない）、データがあれば実行するという意味--}}
        @if (!is_null($headline))
            <div class="row">
                <div class="headline col-md-10 mx-auto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="caption mx-auto">
                                
                                <div class="image">
                                    @if ($headline->image_path)
                                        {{--画像を表示するコード--}}
                                        {{--assetは、「publicディレクトリ」のパスを返すヘルパとなっています。ヘルパとはviewファイルで使えるメソッドのこと--}}
                                        {{--現在のURLのスキーマ（httpかhttps）を使い、アセットへのURLを生成するメソッド--}}
                                        {{--$headline->image_pathは、保存した画像のファイル名--}}
                                        {{--「.」は文字列を結合する結合演算子と呼ばれるもの、画像のパスを返している--}}
                                        <img src="{{ asset('storage/image/' . $headline->image_path) }}">
                                    @endif
                                </div>
                                
                                <div class="title p-2">
                                    {{--\Str::limit()は、文字列を指定した数値で切り詰めるというメソッド、切り詰める文字の数は半角で認識する--}}
                                    <h1>{{ str_limit($headline->title, 70) }}</h1>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <p class="body mx-auto">{{ str_limit($headline->body, 650) }}</p>
                        </div>
                        
                    </div>
                </div>
            </div>
        @endif
        
        <hr color="#c0c0c0">
        
        <div class="row">
            <div class="posts col-md-8 mx-auto mt-3">
                
                {{--@foreach を使って取得したデータの一つ一つを処理し、各データの idと名前、メールアドレスを表示、@foreach は PHP の foreach ではなく blade の構文--}}
                @foreach($posts as $post)
                
                    <div class="post">
                        <div class="row">
                            <div class="text col-md-6">
                                
                                <div class="date">
                                    {{--formatメソッドは、その名の通りフォーマットするためのメソッド--}}
                                    {{--update_atカラムに保存されているデータは、「2018-12-08 08:57:33.0 UTC (+00:00)」という形になっているため、そのまま表示すると見づらい--}}
                                    {{ $post->updated_at->format('Y年m月d日') }}
                                </div>
                                
                                <div class="title">
                                    {{ str_limit($post->title, 150) }}
                                </div>
                                
                                <div class="body mt-3">
                                    {{ str_limit($post->body, 1500) }}
                                </div>
                                
                            </div>
                            
                            <div class="image col-md-6 text-right mt-4">
                                @if ($post->image_path)
                                    <img src="{{ asset('storage/image/' . $post->image_path) }}">
                                @endif
                            </div>
                            
                        </div>
                    </div>
                    
                    <hr color="#c0c0c0">
                @endforeach
                
            </div>
        </div>
    </div>
    </div>
@endsection