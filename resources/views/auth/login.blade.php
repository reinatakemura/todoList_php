@extends('layouts.app')

@section('content')
<div class="signinPage">
    <div class="container">
        <h2 class="title text-center">todoリストにログイン</h2>
        <div class="text-center m-3">or</div>
        <div class="text-center">
            <p class="acountPage_link">
                <a href="{{ route('register') }}">アカウントを作成</a>
            </p>
        </div>
        <form class="new_user" id="new_user" action="{{ route('login') }}" accept-charset="UTF-8" method="post">
        {{ csrf_field() }}
            <div class="form-group">
                <label for="user_email">メールアドレス</label><br>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus> <!-- oldヘルパー：直前のデータを表示する -->
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong> <!-- 配列形式で結果が返ってくるため、first()で最初のエラーを取得している -->
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="user_password">パスワード</label><br>
                <input id="password" type="password" class="form-control" name="password" required> <!-- <input>要素のrequired属性を指定すると、 その入力項目が入力必須であることをブラウザに知らせることができる -->
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group text-center">
                <input type="submit" name="commit" value="ログインする" class="loginBtn" data-disable-with="ログインする"> <!-- data-disable-with:二重送信防止とかのはず -->
            </div>
        </form>
    </div>
</div>
@endsection
