@if($withdrawal->Status->id == 1)
<span class="badge badge-success">{{$withdrawal->Status->name}}</span>
@elseif($withdrawal->Status->id == 2)
<button class="btn btn-sm btn-outline-danger">{{$withdrawal->Status->name}}</button>
@elseif($withdrawal->Status->id == 3)
<span class="badge badge-info">{{$withdrawal->Status->name}}</span>
@elseif($withdrawal->Status->id == 4)
<button class="btn btn-sm btn-outline-primary">{{$withdrawal->Status->name}}</button>
@endif