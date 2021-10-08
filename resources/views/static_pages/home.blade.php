@extends('layouts.default')

@section('content')
  @if (Auth::check())
    <div>
      <div>
        <section>
          @include('shared._status_form')
        </section>
        <h4>微博列表</h4>
        <hr>
        @include('shared._feed')
      </div>
      <aside>
        <section>
          @include('shared._user_info',['user'=>Auth::user()])
        </section>
      </aside>
    </div>
  @else
    <div class="jumbotron">
      <h1>Hello Laravel</h1>
      <p class="lead">
        你现在看到的是<a href="https://learnku.com/courses/laravel-essential-training">Laravel 入门教程</a>的示例项目主页
      </p>
      <p>
        一切将从这里run
      </p>
      <p>
        <a class="btn btn-lg btn-success" href="{{route('signup')}}" role="button">现在注册</a>
      </p>
    </div>
  @endif
@stop
