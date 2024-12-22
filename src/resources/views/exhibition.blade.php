@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="css/profile_edit.css">
<link rel="stylesheet" href="css/exhibition.css">
<script src="{{ asset('/js/upload_image.js') }}"></script>
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
            <li class="header-nav__list">
                <form class="header-nav__list-item" action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="header-nav__list-item">ログアウト</button>
                </form>
            </li>
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
<div class="content--small">
    <div class="common-ttl">商品の出品</div>
    <div class="form">
        <form class="form__inner" action="/sell" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-item">
                <p class="form-item__label">商品画像</p>
                <span class="error-message">@error('item_image')
                    {{$message}}
                    @enderror
                </span>
                <div class="image-container--transparent">
                    <label class="link-bottun--border" for="imageInput">画像を選択する</label>
                    <input class="input-image" type="file" id="imageInput" accept=".jpeg,.png" name="item_image">
                    <img id="preview" src="">
                </div>
            </div>
            <h3 class="exhibition-ttl">商品の詳細</h3>
            <div class="form-item">
                <p class="form-item__label">カテゴリー</p>
                <span class="error-message">
                    @error('categories')
                    {{$message}}
                    @enderror
                </span>
                <div class="category-group">
                    @foreach ($categories as $category)
                    <label class="form-item__category-label" for="{{$category->category}}">
                        <input id="{{$category->category}}" class="form-item__checkbox" type="checkbox"
                            name="categories[]" value="{{$category->id}}" {{old('categories',[]) &&
                            in_array($category->id,old('categories')) ? 'checked' : ''}} multiple>
                        <span>{{$category->category}}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="form-item">
                <label class="form-item__label">商品の状態</label>
                <span class="error-message">
                    @error('condition')
                    {{$message}}
                    @enderror
                </span>
                <select class="form-item__select" name="condition">
                    <option value="" hidden>選択してください</option>
                    @foreach ($conditions as $condition)
                    <option value="{{$condition->id}}" @if (old('condition')==$condition->id )selected @endif>
                        {{$condition->condition}}
                    </option>
                    @endforeach
                </select>
            </div>
            <h3 class="exhibition-ttl">商品名と説明</h3>
            <div class="form-item">
                <label class="form-item__label">商品名</label>
                <span class="error-message">
                    @error('item_name')
                    {{$message}}
                    @enderror
                </span>
                <input class="form-item__input" type="text" name="item_name" value="{{old('item_name')}}">
            </div>
            <div class="form-item">
                <label class="form-item__label">ブランド名</label>
                <input class="form-item__input" type="text" name="brand" value="{{old('brand')}}">
            </div>
            <div class="form-item">
                <label class="form-item__label">商品の説明</label>
                <span class="error-message">
                    @error('description')
                    {{$message}}
                    @enderror
                </span>
                <textarea class="form-item__detail" name="description" cols=""
                    rows="5">{{old('description')}}</textarea>
            </div>
            <div class="form-item">
                <label class="form-item__label">販売価格</label>
                <span class="error-message">
                    @error('price')
                    {{$message}}
                    @enderror
                </span>
                <input class="form-item__input" type="number" name="price" placeholder="&yen;" value="{{old('price')}}">
            </div>
            <div class="form-item">
                <button class="form-item__button" type="submit">出品する</button>
            </div>
        </form>
    </div>
</div>
@endsection