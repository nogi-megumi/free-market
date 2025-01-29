@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="content--small">
    <p class="verify-email__ttl">メールをご確認ください。</p>
    <p class="verify-email__text">登録されたメールアドレス宛てにメールを送信しました。</p>
    <p class="verify-email__text">もし確認用メールが送信されていない場合は、下記をクリックしてください。</p>
    <form class="verify-send__form" method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="verify-send__button">確認メールを再送信する</button>
    </form>
</div>

@endsection