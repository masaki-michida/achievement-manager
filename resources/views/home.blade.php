@extends('layouts.app')

@section('content')
<meta http-equiv="refresh" content=" 3; url=/mypage">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('ようこそ')}} {{Auth::user()->name}} さん</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('ログインに成功しました') }}
                    <p class="redirect">3秒後にマイページへ飛びます<p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection