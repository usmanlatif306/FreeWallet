@if($transaction->Status->id == 1)
<span class="badge badge-success">{{$transaction->Status->name}}</span>
@elseif($transaction->Status->id == 2)
<span class="badge badge-danger">{{$transaction->Status->name}}</span>
@elseif($transaction->Status->id == 3)
<span class="badge badge-info">{{$transaction->Status->name}}</span>
@elseif($transaction->Status->id == 4)
<span class="badge badge-primary">{{$transaction->Status->name}}</span>
@endif