<li class="media mt-4 mb-4">
  <a href="{{route('users.show',$user->id)}}">
    <img src="{{$user->gravatar()}} alt={{$user->name}}" class="mr-3 gravatar"/>
  </a>
  <div class="midia-body">
    <h5 class="mt-0 mb-1">
      {{$user->name}}
      <samll>
        /{{$status->created_at->diffForHumans()}}
      </samll>
    </h5>
    {{$status->content}}
  </div>
</li>



























