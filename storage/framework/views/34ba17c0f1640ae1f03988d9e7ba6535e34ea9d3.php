

<?php $__env->startSection('content'); ?>

    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 ">
            <div class="card">
            <div class="header">
                <h2><strong>#<?php echo e($ticket->ticket_id); ?></strong>   - <?php echo e($ticket->title); ?></h2>
                
            </div>
            <div class="body">
               <div class="ticket-info">
                        <p><?php echo e($ticket->message); ?></p>
                        <p>Categry: <?php echo e($category->name); ?></p>
                        <p>
                        <?php if($ticket->status === 'Open'): ?>
                            Status: <span class="btn btn-success"><?php echo e($ticket->status); ?></span>
                        <?php else: ?>
                            Status: <span class="btn btn-danger"><?php echo e($ticket->status); ?></span>
                        <?php endif; ?>
                        </p>
                        <p>Created on: <?php echo e($ticket->created_at->diffForHumans()); ?></p>
                    </div>
                    <hr>

                    <div class="comments">
                        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="panel panel-<?php if($ticket->user->id === $comment->user_id): ?> <?php echo e("default"); ?><?php else: ?><?php echo e("success"); ?><?php endif; ?>">
                                <div class="panel panel-heading">
                                    <span class="text-primary"><?php echo e($comment->user->name); ?></span>
                                    <span class="pull-right"><?php echo e($comment->created_at->format('Y-m-d')); ?></span>
                                </div>

                                <div class="panel panel-body">
                                    <strong><?php echo e($comment->comment); ?> </strong>    
                                </div>
                            </div>
                              <hr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <?php if($ticket->status != 'Closed'): ?>
                    <hr>
                    <div class="comment-form">
                        <form action="<?php echo e(url('comment')); ?>" method="POST" class="form">
                            <?php echo csrf_field(); ?>


                            <input type="hidden" name="ticket_id" value="<?php echo e($ticket->id); ?>">

                            <div class="form-group<?php echo e($errors->has('comment') ? ' has-error' : ''); ?>">
                                <textarea rows="10" id="comment" class="form-control" name="comment"></textarea>

                                <?php if($errors->has('comment')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('comment')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>                         
                
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>