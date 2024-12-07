@extends('layouts.app')

@section('content')
<div class="content--small">
    <div class="common-ttl">ログイン</div>
    <div class="form">
        <form class="form__inner" action="/login" method="post">
            <div class="form-item">
                <label class="form-item__label" for="">ユーザー名/メールアドレス</label>
                <input class="form-item__input" type="text" name="email">
            </div>
            <div class="form-item">
                <label class="form-item__label" for="">パスワード</label>
                <input class="form-item__input" type="password" name="password">
            </div>
            <div class="form-item">
                <button class="form-item__button">ログインする</button>
            </div>
        </form>
        <div class="form-item">
            <a class="form-item__switch" href="/register">会員登録はこちら</a>
        </div>
    </div>
</div>
@endsection