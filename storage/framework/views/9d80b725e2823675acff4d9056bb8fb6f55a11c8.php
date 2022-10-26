 <div class="col-md-3">
    <div class="card ">
        <!-- overflowhidden -->
        <div class="header">
            <h2><strong><?php echo e(Auth::user()->currentCurrency()->name); ?></strong> <?php echo e(__('Balance')); ?></h2>
            <ul class="header-dropdown">
                <?php if(count(\App\Models\Currency::where('id', '!=', Auth::user()->currentCurrency()->id)->get())): ?>
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-refresh"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right slideUp float-right">
                            <?php $__currentLoopData = \App\Models\Currency::where('id', '!=', Auth::user()->currentCurrency()->id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <li>
                                <a href="<?php echo e(url('/')); ?>/wallet/<?php echo e($currency->id); ?>"><span> <?php echo e($currency->name); ?></span></a>
                                </li> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                <?php endif; ?>
               
            </ul>
        </div>
        <div class="body">
            <small></small> 
           
            <h2 style="margin-bottom: 0;"><?php echo e(\App\Helpers\Money::instance()->value(Auth::user()->balance(), Auth::user()->currentCurrency()->symbol)); ?></h2>
            <p><a href="<?php echo e(url('/')); ?>/exchange/first/0/second/0"><?php echo e(__('Convert Currency')); ?></p></a>
          
            <a href="<?php echo e(route('withdrawal.form')); ?>" class="btn btn-primary btn-round bg-blue"><?php echo e(__('Withdraw funds')); ?></a>
        </div>
        
    </div>
    <?php if(Route::is('home')): ?>

    <?php if(!empty($myEscrows)): ?>
    
    <?php $__currentLoopData = $myEscrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $escrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="card">
            <div class="header">
                <h2><strong>On Hold</strong> #<?php echo e($escrow->id); ?></h2>
                <ul class="header-dropdown">
                    <li class="remove">
                        <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <h3 class="mb-0 pb-0">
               -  <?php echo e(\App\Helpers\Money::instance()->value( $escrow->gross, $escrow->currency_symbol )); ?>       
                </h3>
                Escrow money to  <a href="<?php echo e(url('/')); ?>/escrow/<?php echo e($escrow->id); ?>"><span class="text-primary"><?php echo e($escrow->toUser->name); ?></span></a> <br> 
                <form action="<?php echo e(url('/')); ?>/escrow/release" method="post">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="eid" value="<?php echo e($escrow->id); ?>">
                    <input type="submit" class="btn btn-sm btn-round btn-primary btn-simple" value="<?php echo e(_('Release')); ?>">
                    
                </form>
            </div>
        </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    <?php endif; ?> 
    
    <?php if(!empty($toEscrows)): ?>
    
    <?php $__currentLoopData = $toEscrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $escrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="card">
            <div class="header">
                <h2><strong>On Hold</strong> #<?php echo e($escrow->id); ?></h2>
                <ul class="header-dropdown">
                    <li class="remove">
                        <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <h3 class="mb-0 pb-0">
                +  <?php echo e(\App\Helpers\Money::instance()->value( $escrow->gross, $escrow->currency_symbol )); ?>       
                </h3>
                Escrow money from <a href="<?php echo e(url('/')); ?>/escrow/<?php echo e($escrow->id); ?>"><span class="text-primary"><?php echo e($escrow->User->name); ?></span></a> 
                <form action="<?php echo e(url('/')); ?>/escrow/refund" method="post">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="eid" value="<?php echo e($escrow->id); ?>">
                    <input type="submit" class="btn btn-sm btn-round btn-danger btn-simple" value="<?php echo e(_('refund')); ?>">
                </form>
            </div>
        </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    <?php endif; ?> 

    <?php endif; ?>
 
    <?php if(Auth::user()->role_id == 1 or Auth::user()->is_ticket_admin ): ?>
    <div class="card hidden-sm">
        <div class="header">
            <h2><strong>Admin</strong> area</h2>
            <ul class="header-dropdown">
                <li class="remove">
                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                </li>
            </ul>
        </div>
        <div class="body">
                   <h5 class="card-title">Howdy Mr. admin <?php echo e(Auth::user()->name); ?></h5>
                <p class="card-text">In this section you have links that are only visible to admins.</p>
                 <div class="list-group mb-2">
                    <a href="<?php echo e(route('makeVouchers')); ?>" class="list-group-item list-group-item-action <?php echo e((Route::is('makeVouchers') ? 'active' : '')); ?>"><?php echo e(__('Generate Vouchers')); ?></a>
                    <?php if(Auth::user()->is_ticket_admin): ?>
                        <a href="<?php echo e(url('ticketadmin/tickets')); ?>" class="list-group-item list-group-item-action <?php echo e((Route::is('support') ? 'active' : '')); ?>"><?php echo e(__('Manage Tickets')); ?></a>
                    <?php endif; ?>
                    <?php if(Auth::user()->role_id == 1): ?>
                        <a href="<?php echo e(url('/')); ?>/update_rates" class="list-group-item list-group-item-action "><?php echo e(__('Update Exchange Rates')); ?></a>
                    <?php endif; ?>
                </div>
                <a href="<?php echo e(url('/')); ?>/admin" class="btn btn-primary btn-round">Go to admin dashboard</a>                  
            
        </div>
    </div> 
    <?php endif; ?>
    <?php if(!Route::is('exchange.form')): ?>
     
    <div class="list-group">
        
    </div>
    <?php endif; ?>
</div>