<div class="card" id="details">
    <div class="body">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="border-top: 0;">#</th>
                                <th style="border-top: 0;">Quantity</th>
                                <th style="border-top: 0;" class="hidden-sm-down">Unit Cost</th>
                                <th style="border-top: 0;">Total</th>                     
                                <th style="border-top: 0;">Item</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(session()->get('PurchaseRequest')->data->items as $item)
                                <tr>
                                    <td>{{$loop->index}}</td>
                                    <td>{{$item->qty}}</td>
                                    <td>{{\App\Helpers\Money::instance()->value($item->price)}}{{session()->get('PurchaseRequest')->currency->symbol}} </td>
                                    <td>{{\App\Helpers\Money::instance()->value($item->price * $item->qty)}}{{session()->get('PurchaseRequest')->currency->symbol}}</td>
                                    <td>{{$item->name}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <hr>
        <div class="row clearfix">
            <div class="col-md-6">
              
            </div>
            <div class="col-md-6 text-right">
                <p class="m-b-0"><b>Sub-total:</b> {{\App\Helpers\Money::instance()->value(session()->get('PurchaseRequestTotal'))}}</p>                                      
                <h3 class="m-b-0 m-t-10">{{session()->get('PurchaseRequest')->currency->code}} {{\App\Helpers\Money::instance()->value(session()->get('PurchaseRequestTotal'))}}</h3>
            </div>                                    
           
        </div>
    </div>
</div>