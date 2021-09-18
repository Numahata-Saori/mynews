{{--テンプレート（viewファイル）の継承（読み込み）をおこなうメソッド--}}
@extends('layouts.admin')

{{--@sectionは、名前が示す通りにコンテンツのセクションを定義--}}
{{--「admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む」が動作--}}
@section('title', '登録済みニュースの一覧')

{{--「admin.blade.phpの@yield('content')に以下のタグを埋め込む」という動作--}}
@section('content')
    <div class="container">
        <div class="row">
            <h2>ニュース一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('Admin\NewsController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Admin\NewsController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_title" value={{ $cond_title }}>
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="admin-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="20%">タイトル</th>
                                <th width="50%">本文</th>
                                <th width="10%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            {{--@foreach を使って取得したデータの一つ一つを処理し、各データの idと名前、メールアドレスを表示--}}、
                            @foreach($posts as $news)
                                <tr>
                                    <th>{{ $news->id }}</th>
                                    
                                    {{--\Str::limit()は、文字列を指定した数値で切り詰めるというメソッド、切り詰める文字の数は半角で認識する--}}
                                    <td>{{ str_limit($news->title, 100) }}</td>
                                    <td>{{ str_limit($news->body, 250) }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ action('Admin\NewsController@edit', ['id' => $news->id]) }}">編集</a>
                                        </div>
                                        <div>
                                            <a href="{{ action('Admin\NewsController@delete', ['id' => $news->id]) }}">削除</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection