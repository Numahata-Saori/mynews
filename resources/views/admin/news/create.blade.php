{{--テンプレート（viewファイル）の継承（読み込み）をおこなうメソッド--}}
@extends('layouts.admin')

{{--@sectionは、名前が示す通りにコンテンツのセクションを定義--}}
{{--「admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む」が動作--}}
@section('title', 'ニュースの新規作成')

{{--「admin.blade.phpの@yield('content')に以下のタグを埋め込む」という動作--}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>ニュース新規作成</h2>
                <form action="{{ action('Admin\NewsController@create') }}" method="post" enctype="multipart/form-data">

                    {{--count($errors) → `$errors` は `validate` で弾かれた内容を記憶する配列のこと、countメソッドは配列の個数を返すメソッド--}}
                    {{--エラーがなければ$errorsはnullを返すのでcount($errors)は0を返す--}}
                    @if (count($errors) > 0)
                        <ul>
                            {{--@foreach($errors->all() as $e) → foreachは配列の数だけループする構文、$errorsの中身の数だけループし、その中身を$eに代入、$eに代入された中身を<li>{{ $e }}</li>で表示--}}
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    {{--`old('変数名') → 入力フォームから送信など次画面に進んだ際、エラーがあって、最初の入力フォームに戻されたときに、入力された内容をそのまま「自動入れ直してあげる」便利な機能--}}
                    {{--old('変数名' , '初期値') → 「編集機能ですでに保存された値を初期値にしたい、入力された値も反映されるようにしたい」といった場合に、使う構文もある--}}
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2">本文</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="body" rows="20">{{ old('body') }}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2">画像</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                        </div>
                    </div>
                    
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="更新">
                </form>
            </div>
        </div>
    </div>
@endsection