 <div class="col-md-3">
     <div class="card info-box-2 l-seagreen">
         <!-- overflowhidden -->
         <div class="header">
             <h2> <strong style="color:#191f28"><?php echo e(__('Balance')); ?></strong></h2>
             <ul class="header-dropdown">
                 <a href="<?php echo e(route('receivedMoneyForm',app()->getLocale())); ?>" class="">
                     <span class="badge badge-success" style="border-color: white;"><?php echo e(__('Received')); ?></span> </a>
                 <li class=" dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                         <span class="badge badge-success" style="border-color: white;"><?php echo e(__('Request')); ?></span> </a>
                     <ul class="dropdown-menu dropdown-menu-right slideUp float-right">
                         <?php $__currentLoopData = \App\Models\Wallet::where('id', '!=', Auth::user()->currentWallet()->id)->where('user_id', Auth::user()->id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <li>


                         </li>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                         <li>
                             <a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/deposit/<?php echo e(Auth::user()->currentWallet()->id); ?>"><?php echo e(__('DEPOSIT')); ?></a>
                             <hr style="margin: 0;">
                         </li>

                         <li>
                             <a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/payout/<?php echo e(Auth::user()->currentWallet()->id); ?>"><?php echo e(__('WITHDRAW')); ?></a>
                             <hr style="margin: 0;">
                         </li>
                         
             </ul>
             </li>


             </ul>
         </div>
         <div class="body" style="padding-top: 0">
             <div class="content d-flex justify-content-between align-items-center">
                 <?php
                 $balance = Auth::user()->balance() + Auth::user()->walletBalance();
                 ?>
                 <div class="number " style="color: white !important"><?php echo e(\App\Helpers\Money::instance()->value($balance, Auth::user()->currentCurrency()->symbol)); ?></div>
                 <?php echo QrCode::size(100)->generate(Auth::user()->address());; ?>

             </div>
             <div class="clearfix"></div>

             <div class="content">
                 <span><?php echo e(Auth::user()->currentWallet()->currency->name); ?></span>
                 <span style="font-size: 12px;"><?php echo e(Auth::user()->address()); ?></span>
             </div>
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
                 - <?php echo e(\App\Helpers\Money::instance()->value( $escrow->gross, $escrow->currency_symbol )); ?>

             </h3>
             Escrow money to <a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/escrow/<?php echo e($escrow->id); ?>"><span class="text-primary"><?php echo e($escrow->toUser->name); ?></span></a> <br>
             <form action="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/escrow/release" method="post">
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
                 + <?php echo e(\App\Helpers\Money::instance()->value( $escrow->gross, $escrow->currency_symbol )); ?>

             </h3>
             Escrow money from <a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/escrow/<?php echo e($escrow->id); ?>"><span class="text-primary"><?php echo e($escrow->User->name); ?></span></a>
             <form action="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/escrow/refund" method="post">
                 <?php echo e(csrf_field()); ?>

                 <input type="hidden" name="eid" value="<?php echo e($escrow->id); ?>">
                 <input type="submit" class="btn btn-sm btn-round btn-danger btn-simple" value="<?php echo e(_('refund')); ?>">
             </form>
         </div>
     </div>

     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

     <?php endif; ?>

     <?php endif; ?>
     <?php if(count(Auth::user()->wallets())): ?>
     <?php $__currentLoopData = Auth::user()->wallets(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $someWallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     <div class="row ">
         <div class="col">
             <a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/wallet/<?php echo e($someWallet->id); ?>">
                 <div class="card info-box-2" style="cursor: pointer;min-height: auto;">
                     <div class="header" style="padding-bottom: 0">
                         <h2><strong><?php echo e($someWallet->currency->name); ?></strong> <?php echo e(__('Balance')); ?></h2>
                         <ul class="header-dropdown">
                             <li class="remove">

                             </li>
                         </ul>
                     </div>
                     <div class="body" style="padding-top: 0;padding-bottom: 0;">
                         <div class="content">
                             <div class="number"><?php echo e(\App\Helpers\Money::instance()->value($someWallet->amount, $someWallet->currency->symbol)); ?></div>

                         </div>
                     </div>
                 </div>
             </a>
         </div>
     </div>
     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                 <a href="<?php echo e(route('makeVouchers', app()->getLocale())); ?>" class="list-group-item list-group-item-action <?php echo e((Route::is('makeVouchers') ? 'active' : '')); ?>"><?php echo e(__('Generate Vouchers')); ?></a>
                 <?php if(Auth::user()->is_ticket_admin): ?>
                 <a href="<?php echo e(url('ticketadmin/tickets')); ?>" class="list-group-item list-group-item-action <?php echo e((Route::is('support') ? 'active' : '')); ?>"><?php echo e(__('Manage Tickets')); ?></a>
                 <?php endif; ?>
                 <?php if(Auth::user()->role_id == 1): ?>
                 <a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/update_rates" class="list-group-item list-group-item-action "><?php echo e(__('Update Exchange Rates')); ?></a>
                 <?php endif; ?>
             </div>
             <a href="<?php echo e(url('/')); ?>/admin/dashboard" class="btn btn-primary btn-round">Go to admin dashboard</a>

         </div>
     </div>
     <?php endif; ?>
     <?php if(Auth::user()->role_id == 3): ?>
     <div class="card hidden-sm">
         <div class="header">
             <h2><strong>Agent</strong> area</h2>
             <ul class="header-dropdown">
                 <li class="remove">
                     <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                 </li>
             </ul>
         </div>
         <div class="body ">
             <h5 class="card-title">Howdy Mr. Agent <?php echo e(Auth::user()->name); ?></h5>
             <p class="card-text">In this section you have links that are only visible to Agents</p>
             <div class="list-group mb-2">
                 <a href="<?php echo e(route('makeVouchers', app()->getLocale())); ?>" class="list-group-item list-group-item-action <?php echo e((Route::is('makeVouchers') ? 'active' : '')); ?>"><?php echo e(__('Recharge Vouchers')); ?></a>
             </div>
         </div>
     </div>
     <?php endif; ?>
     <?php if(!Route::is('exchange.form')): ?>

     <div class="list-group">

     </div>
     <?php endif; ?>
 </div>