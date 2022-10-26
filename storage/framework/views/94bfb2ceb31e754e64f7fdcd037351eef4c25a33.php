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
                            <?php $__currentLoopData = session()->get('PurchaseRequest')->data->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->index); ?></td>
                                    <td><?php echo e($item->qty); ?></td>
                                    <td><?php echo e(\App\Helpers\Money::instance()->value($item->price)); ?><?php echo e(session()->get('PurchaseRequest')->currency->symbol); ?> </td>
                                    <td><?php echo e(\App\Helpers\Money::instance()->value($item->price * $item->qty)); ?><?php echo e(session()->get('PurchaseRequest')->currency->symbol); ?></td>
                                    <td><?php echo e($item->name); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <p class="m-b-0"><b>Sub-total:</b> <?php echo e(\App\Helpers\Money::instance()->value(session()->get('PurchaseRequestTotal'))); ?></p>                                      
                <h3 class="m-b-0 m-t-10"><?php echo e(session()->get('PurchaseRequest')->currency->code); ?> <?php echo e(\App\Helpers\Money::instance()->value(session()->get('PurchaseRequestTotal'))); ?></h3>
            </div>                                    
           
        </div>
    </div>
</div>