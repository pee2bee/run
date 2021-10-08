@extends('layouts.default')
@section('title',$user->name)


@section('content')
<div class="row">
  <div class="offset-md-2 col-md-8">
    <section class="user_info">
      @include('shared._user_info', ['user' => $user])
    </section>

    <section>
      @if($statuses->count() > 0)
      <u1>
        @foreach($statuses as $status)
          @include('statuses._status')
        @endforeach
      </u1>
      <div class="mt-5">
        {!! $statuses->render() !!}
      </div>
      @else
        <p>没有数据！ </p>
      @endif
    </section>
  </div>
</div>
@stop










