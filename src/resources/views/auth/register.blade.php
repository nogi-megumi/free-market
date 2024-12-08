@extends('layouts.app')

@section('content')
<div class="content--small">
    <div class="common-ttl">会員登録</div>
    <div class="form">
        <form class="form__inner" action="/register" method="post">
            @csrf
            <div class="form-item">
                <label class="form-item__label">ユーザー名</label>
                <input class="form-item__input" type="text" name="name" value="{{old('name')}}">
                <p class="error-message">
                    @error('name')
                    {{$message}}
                    @enderror
                </p>
            </div>
            <div class="form-item">
                <label class="form-item__label">メールアドレス</label>
                <input class="form-item__input" type="text" name="email" value="{{old('email')}}">
                <p class="error-message">
                    @error('email')
                    {{$message}}
                    @enderror
                </p>
            </div>
            <div class="form-item">
                <label class="form-item__label">パスワード</label>
                <input class="form-item__input" type="password" name="password">
                <p class="error-message">
                    @error('password')
                    {{$message}}
                    @enderror
                </p>
            </div>
            <div class="form-item">
                <label class="form-item__label">確認用パスワード</label>
                <input class="form-item__input" type="password" name="password_confirmation">
                <p class="error-message">
                    @error('password')
                    {{$message}}
                    @enderror
                </p>
            </div>
            <div class="form-item">
                <button class="form-item__button" type="submit">登録する</button>
            </div>
        </form>
        <div class="form-item">
            <a class="form-item__switch" href="/login">ログインはこちら
            </a>
        </div>
    </div>
</div>
@endsection