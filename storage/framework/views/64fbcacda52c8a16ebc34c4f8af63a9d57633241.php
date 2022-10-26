<?php $__env->startPush('stylesheet'); ?>
<link rel="stylesheet" href="<?php echo e(asset('face/css/style.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
    <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="col-md-9 " style="padding-right: 0" id="#addFund">
        <?php echo $__env->make('flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="card">
            <div class="header">
                <h2><strong><?php echo e(__('Identity')); ?></strong> <?php echo e(__("Verification Through Camera")); ?>

                </h2>
            </div>
            <div class="body">
                <!-- faceki section start -->
                <section class="faceki-section d-flex flex-wrap align-items-center justify-content-center w-100">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-10 col-lg-6 col-xl-5 mx-auto">
                                <div class="faceki-card faceki-card-dark">
                                    <h2 class="faceki-card__title">Verify Your Identity</h2>
                                    <span class="faceki-card__sub-title">It will only take few seconds</span>
                                    <ul class="faceki-card__list" id="kyc_items">
                                    </ul>
                                    <button onclick="goToScannerPage()" class="faceki-card__btn">START</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- faceki section end -->

            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('face/js/faceki-startup.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>