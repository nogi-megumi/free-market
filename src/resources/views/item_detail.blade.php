@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/item_index.css')}}">
<link rel="stylesheet" href="{{asset('css/exhibition.css')}}">
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<link rel="stylesheet" href="{{asset('css/item_detail.css')}}">
@endsection

@section('header-item')
<div class="header-search">
    <form class="header-search-form" action="/" method="POST" action="">
        @csrf
        <input class="header-search-form__input" name="keyword" value="{{ request('keyword') }}" type="text"
            placeholder="何をお探しですか？" type="text" placeholder="何をお探しですか？">
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
                <p class="detail-text--small">{{$item->brand ?? ''}}</p>
                <p class="detail-text--small">&yen;<span
                        class="detail-price">{{number_format($item->price)}}</span>&#40;税込み&#41;</p>
                <div class="icon-group">
                    <div class="icon-group__item">
                        <form action="{{route('item.like',$item)}}" method="post">
                            @csrf
                            <button class="icon__button--submit" type="submit">
                                <div class="icon__button--star">
                                    @guest
                                    <svg width="30" height="30" viewBox="0, -10, 150, 190">
                                        <path
                                            d="M75 0 L55 50 L0 50 L40 90 L15 150 L75 115 L135 150 L110 90 L150 50 L95 50 Z"
                                            fill="transparent" stroke="#000000" stroke-width="4">
                                        </path>
                                    </svg>
                                    @endguest
                                    @auth
                                    @if ($item->isLiked)
                                    <svg class="like" width="30" height="30" viewBox="0, -10, 150, 190">
                                        <path
                                            d="M75 0 L55 50 L0 50 L40 90 L15 150 L75 115 L135 150 L110 90 L150 50 L95 50 Z"
                                            fill="#fcd000" stroke="#000000" stroke-width="4">
                                        </path>
                                    </svg>
                                    @else
                                    <svg width="30" height="30" viewBox="0, -10, 150, 190">
                                        <path
                                            d="M75 0 L55 50 L0 50 L40 90 L15 150 L75 115 L135 150 L110 90 L150 50 L95 50 Z"
                                            fill="transparent" stroke="#000000" stroke-width="4">
                                        </path>
                                    </svg>
                                    @endif
                                    @endauth
                                </div>
                                {{!$item->favorites ? '0' : $item->favorites->count()}}
                            </button>
                        </form>
                    </div>
                    <div class="icon-group__item">
                        <a class="icon__button" href="#コメント">
                            <div class="icon__button--bubble">
                                <svg height='30' width='30' viewBox='0 0 200 200'
                                    style='fill:#ffffff;stroke:#000000;stroke-width:4'>
                                    <path d='M80,160 A70,70 0 1 0 60,150 L55,170 L75,160 Z'></path>
                                </svg>
                            </div>
                            {{!$comments ? '0' : $comments->count()}}
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
                            @foreach ($item->categories as $category)
                            <span>{{$category->category}}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr class="detail-table__tr">
                        <th class="detail-table__th">商品の状態</th>
                        <td class="detail-table__td">
                            {{$item->condition->condition}}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="detail__parts">
                <p class="detail__ttl" id="コメント">コメント&#40;{{!$comments ? '0' : $comments->count()}}&#41;</p>
                @foreach ($comments as $comment)
                <div class="image-group">
                    <div class="image-container--circle">
                        @if ($comment->user->profile && $comment->user->profile->user_image)
                        <img class="image-container__image"
                            src="{{asset('storage/images/' . $comment->user->profile->user_image)}}" alt="ユーザーアイコン">
                    </div>
                    @else
                    <img class="image-container__image image--circle" src="" alt="ユーザーアイコン">
                    @endif
                    <p class="comment__user">{{$comment->user->name}}</p>
                </div>
                <p class="comment__text">{{$comment->comment}}
                </p>
                @endforeach
            </div>
            <form class="" action="{{route('comment.store',$item)}}" method="POST">
                @csrf
                <div class="form-item">
                    <label class="detail__ttl">商品へのコメント</label>
                    <textarea class="form-item__detail" name="comment" cols="" rows="10">{{old('comment')}}</textarea>
                </div>
                <span class="error-message">
                    @error('comment')
                    {{$message}}
                    @enderror
                </span>
                <div class="form-item">
                    <button class="form-item__button" type="submit">コメントを送信する</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection