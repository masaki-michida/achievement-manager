<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0 auto;
                overflow-x:hidden;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                margin-left:auto;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 35px;
            }

            .links > a {
                color: #636b6f;
                padding: 25px 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                font-size:25px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            
            .example-content{
                padding:20px 0 0;
                width: 100vw;
            }

            .example-content::after{
                content:"";
                margin: 30px auto 0px;
                display:block;
                height:3px;
                background-color:silver;
                
            }

            .registbutton{
                height:100px;
                font-size:50px;
                width:100px;
            }

            img{
                max-width: 100%;
                height: auto;
            }

            .links{
                display:flex;
                justify-content:flex-end;
            }

        </style>
    </head>
    <body>
    <title>todoTimer</title>
    <div>
            @if (Route::has('login'))
                <div class="links">
                    @auth
                        <a href="{{ url('/mypage') }}">マイページ</a>
                    @else
                        <a href="{{ route('login') }}">ログイン</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">新規登録</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="example-content">
                    <div class="title">
                        これは何？
                    </div>
                    <div>
                        <p>タイマー付き目標分割todoリストです</p>
                        <img src="image/preview1.jpg" alt="サンプル画像">
                    </div>
                </div>
                <div class="example-content">
                    <div class="title">
                        使い方
                    </div>
                    <div>
                        <p>目標をたてるボタンを押して目標と分割目標を入力</p>
                        <img src="image/preview2.gif" alt="サンプル画像">
                    </div>
                </div>
                <div class="example-content">
                    <div class="title">
                        目標を立てた後は？
                    </div>
                    <div>
                        <p>達成した目標からチェックボックスを押しましょう、達成度が増えていきます</p>
                        <img src="image/preview3.gif" alt="サンプル画像">
                    </div>
                </div>
                <div class="example-content">
                    <div class="title">
                        全ての小目標を達成したら？
                    </div>
                    <div>
                        <p>完了ボタンを押して、目標達成です</p>
                        <img src="image/preview4.gif" alt="サンプル画像">
                    </div>
                </div>
                <div class="example-content">
                    <div class="title">
                        使ってみませんか？
                    </div>
                    @if (Route::has('login'))
                    @auth
                        <div class="links">
                        <a href="{{ url('/mypage') }}">マイページに戻る</a>
                         </div>
                    @else
                        @if (Route::has('register'))
                        <div class="welcome-btn">
                        <a class="btn btn-primary registbutton w-50" href="{{ route('register') }}">welcome</a>
                        @endif
                    @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
