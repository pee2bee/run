{{-- //判断是否是当前用户，是就不予显示 --}}
@can('follow',$user)
<div class="text-center mt-2 mb-4">
  {{-- //判断是否已经关注 --}}
  @if (Auth::user()->isFollowing($user->id))
    {{-- 已经关注，则显示取消关注按钮 --}}
    <form action="{{route('followers.destroy',$user->id)}}" method="post">
      {{ csrf_field() }}
      {{method_field('DELETE')}}
      <button type="submit" class="btn btn-sm btn-outline-primary">取消关注</button>
    </form action="{{route('followers.store',$user->id)}}" method="post">
  @else
    {{-- //未关注 --}}
    <form action="{{route('followers.store',$user->id)}}" method="post">
      {{csrf_field()}}
      <button type="submit" class="btn btn-sm btn-primary">关注</button>
    </form>
  @endif
</div>
@endcan















