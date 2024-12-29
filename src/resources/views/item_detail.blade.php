@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/item_index.css')}}">
<link rel="stylesheet" href="{{asset('css/exhibition.css')}}">
<link rel="stylesheet" href="{{asset('css/profile_edit.css')}}">
<link rel="stylesheet" href="{{asset('css/item_detail.css')}}">
@endsection

@section('header-item')
<div class="header-search">
    <form class="header-search-form" action="">
        @csrf
        <input class="header-search-form__input" type="text" placeholder="何をお探しですか？">
    </form>
</div>
<div class="header-nav">
    <nav>
        <ul class="header-nav__group">
            @if (Auth::check())
            <li class="header-nav__list">
                <form class="header-nav__list-item" action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="header-nav__list-item">ログアウト</button>
                </form>
            </li>
            @else
            <li class="header-nav__list">
                <a class="header-nav__list-item" href="/login">ログイン</a>
            </li>
            @endif </li>
            <li class="header-nav__list">
                <a class="header-nav__list-item" href="/mypage">マイページ</a>
            </li>
            <li class="header-nav__list">
                <a class="header-nav__list-item link--exhibition" href="/sell">出品</a>
            </li>
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="content--large">
    <div class="content__grid">
        <div class="content__grid-column column__image">
            <div class="image-container--large">
                <img class="image-container__image" src="{{asset('storage/images/' . $item->item_image)}}"
                    alt="{{$item->item_name}}">
            </div>
        </div>
        <div class="content__grid-column">
            <div class="detail__parts">
                <p class="detail-text--large">{{$item->item_name}}</p>
                <p class="detail-text--small">{{$item->band ?? ''}}</p>
                <p class="detail-text--small">&yen;<span class="detail-price">{{$item->price}}</span>&#40;税込み&#41;</p>
                <div class="icon-group">
                    <div class="icon-group__item">
                        <a class="icon__button like-button" href="">
                            <div class="icon__button--star">
                                <svg width="30" height="30" viewBox="0, -10, 150, 190">
                                    <path
                                        d="M75 0 L55 50 L0 50 L40 90 L15 150 L75 115 L135 150 L110 90 L150 50 L95 50 Z"
                                        fill="none" stroke="#000000" stroke-width="4">
                                    </path>
                                </svg>
                            </div>
                            4{{-- カウント数を挿入 --}}
                        </a>
                    </div>
                    <div class="icon-group__item">
                        <a class="icon__button" href="#コメント">
                            <div class="icon__button--bubble">
                                <svg height='30' width='30' viewBox='0 0 200 200'
                                    style='fill:#ffffff;stroke:#000000;stroke-width:4'>
                                    <path d='M80,160 A70,70 0 1 0 60,150 L55,170 L75,160 Z'></path>
                                </svg>
                            </div>
                            1{{-- カウント数を挿入 --}}
                        </a>
                    </div>
                </div>
                <div class="form-item">
                    <a class="form-item__button" href="/purchase">購入手続きへ</a>
                </div>
            </div>
            <div class="detail__parts">
                <p class="detail__ttl">商品説明</p>
                <p class="detail-text--small">
                    {{$item->description}}
                </p>
            </div>
            <div class="detail__parts">
                <p class="detail__ttl">商品の情報</p>
                <table class="dtail-table">
                    <tr class="detail-table__tr">
                        <th class="detail-table__th">カテゴリー</th>
                        <td class="detail-table__td td__category">
                            {{-- 出品ページ、カテゴリーを挿入 --}}
                            <span>洋服</span>
                            <span>メンズ</span>
                        </td>
                    </tr>
                    <tr class="detail-table__tr">
                        <th class="detail-table__th">商品の状態</th>
                        <td class="detail-table__td">
                            {{-- 出品ページ、商品の状態を挿入 --}}
                            {{$item->condition->condition}}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="detail__parts">
                <p class="detail__ttl" id="コメント">コメント&#40;1&#41;</p>
                <div class="image-group">
                    <div class="image-container--circle">
                        <img class="image-container__image" src="" alt="アイコン">
                    </div>
                    <p class="comment__user">admin</p>
                </div>
                <p class="comment__text">ここにコメントが入る</p>
            </div>
            <form class="">
                @csrf
                <div class="form-item">
                    <label class="detail__ttl">商品へのコメント</label>
                    <textarea class="form-item__detail" name="detail" cols="" rows="10"></textarea>
                </div>
                <div class="form-item">
                    <button class="form-item__button">コメントを送信する</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection