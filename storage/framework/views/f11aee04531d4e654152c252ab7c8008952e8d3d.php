

<?php $__env->startSection('content'); ?>
   
    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 ">
            <div class="card">
            <div class="header">
                <h2><strong><?php echo e(__('Tickets')); ?></strong></h2>
            </div>
            <div class="body">
                  <?php if($tickets->isEmpty()): ?>
                        <p><?php echo e(__('There are currently no tickets.')); ?></p>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Category')); ?></th>
                                    <th><?php echo e(__('Title')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Last Updated')); ?></th>
                                    <th style="text-align:center" colspan="2"><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($category->name); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(url('tickets/'. $ticket->ticket_id)); ?>">
                                            #<?php echo e($ticket->ticket_id); ?> - <?php echo e($ticket->title); ?>

                                        </a>
                                    </td>
                                    <td>
                                    <?php if($ticket->status === 'Open'): ?>
                                        <span class="label label-success"><?php echo e($ticket->status); ?></span>
                                    <?php else: ?>
                                        <span class="label label-danger"><?php echo e($ticket->status); ?></span>
                                    <?php endif; ?>
                                    </td>
                                    <td><?php echo e($ticket->updated_at); ?></td>
                                    <?php if($ticket->status != 'Closed'): ?>
                                        <td>
                                            <a href="<?php echo e(url('tickets/' . $ticket->ticket_id)); ?>" class="btn btn-primary"><?php echo e(__('Comment')); ?></a>
                                        </td>
                                        <td>
                                            <form action="<?php echo e(url('ticketadmin/close_ticket/' . $ticket->ticket_id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>

                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Close')); ?></button>
                                            </form>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                        <?php echo e($tickets->render()); ?>

                    <?php endif; ?>                       
                
            </div>
        </div>

            
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>