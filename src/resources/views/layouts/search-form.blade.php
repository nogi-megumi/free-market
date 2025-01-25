<div class="header-search">
    <form class="header-search-form" action="/" method="POST">
        @csrf
        <input class="header-search-form__input" name="keyword" value="{{ request('keyword') }}" type="text"
            placeholder="何をお探しですか？">
    </form>
</div>