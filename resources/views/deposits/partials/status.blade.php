@if($deposit->Status->id == 1)
<span class="badge badge-success">{{$deposit->Status->name}}</span>
@elseif($deposit->Status->id == 2)
<button class="btn btn-sm btn-outline-danger">{{$deposit->Status->name}}</button>
@elseif($deposit->Status->id == 3)
<span class="badge badge-info">{{$deposit->Status->name}}</span>
@elseif($deposit->Status->id == 4)
<button class="btn btn-sm btn-outline-primary">{{$deposit->Status->name}}</button>
@endif