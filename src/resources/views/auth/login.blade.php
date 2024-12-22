@extends('layouts.app')

@section('content')
<div class="content--small">
    <div class="common-ttl">ログイン</div>
    <div class="form">
        <form class="form__inner" action="/login" method="post">
            @csrf
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
                <p class="error-message">
                    @error('name')
                    {{$message}}
                    @enderror
                </p>
            </div>
            <div class="form-item">
                <button class="form-item__button" type="submit">ログインする</button>
            </div>
        </form>
        <div class="form-item">
            <a class="form-item__switch" href="/register">会員登録はこちら</a>
        </div>
    </div>
</div>
@endsection