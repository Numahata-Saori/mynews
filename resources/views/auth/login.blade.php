@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-box card">
                    
                    {{--ヘルパ関数、「__(‘Login’)」→ この「__」は、ヘルパ関数（viewで使うための関数）の一種で、翻訳文字列の取得として使う--}}
                    <div class="login-header card-header mx-auto">{{ __('messages.Login') }}</div>

                    <div class="login-body card-body">
                        
                        {{--route関数、{{ route('login') }} → URLを生成したりリダイレクトしたりするための関数、”/login”というURLを生成--}}
                        <form method="POST" action="{{ route('login') }}">
                            
                            {{--認証済みのユーザーがリクエストを送信しているのかを確認するために利用--}}
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('messages.E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    
                                    {{--三項演算子、{{ $errors->has('email') ? ' is-invalid' : '' }}
                                    何もエラーがなければ$errors->has('email') の値はnullになるので:の右側が表示される
                                    エラーがある場合には$errors->has('email') の値にエラーメッセージが代入されるので、" is-invalid"が出力される
                                    $errorsというのは、Validationで返された時に代入されるメッセージが格納されている、そのままエラーメッセージが格納されている変数
                                    has(‘email’)は、emailフィールド（のこと）で発生したエラー内容という意味
                                    {{ old('email') }} → oldヘルパ関数は、セッションにフラッシュデータ（一時的にしか保存されないデータ）として入力されているデータを取得することができる
                                    フラッシュデータとは、直前までユーザーが入力していた値のこと
                                    直前のデータがない場合は、nullを返す--}}
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                    {{--@ifと@endifは、phpのif文を意味
                                    ($errors->has('email')) → エラーがあればエラーメッセージを、なければnullを返す--}}
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('messages.Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('messages.Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('messages.Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection