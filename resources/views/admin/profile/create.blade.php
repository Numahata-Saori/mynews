{{-- layouts/create.blade.phpを読み込む --}}
@extends('layouts.profile')


{{-- layouts/profile.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'プロフィール作成画面')

{{-- layouts/profile.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>My プロフィール</h2>
            </div>
        </div>
    </div>
@endsection