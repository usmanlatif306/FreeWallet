<section id="footer" class="hidden">
		<div class="container">
			<div class="row text-center text-xs-center text-sm-left text-md-left">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="card bg-light">
                    <div class="body block-header">
                    	<h5><?php echo e(__('Help and Support')); ?></h5>
                    	<ul class="list-unstyled quick-links">
						<li><a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/page/4"><i class="fa fa-angle-double-right"></i><?php echo e(__('About')); ?></a></li>
						<li><a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/page/5""><i class="fa fa-angle-double-right"></i><?php echo e(__('FAQ')); ?></a></li>
						<li><a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/page/3"><i class="fa fa-angle-double-right"></i><?php echo e(__('Terms of Use')); ?></a></li>
						<li><a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/page/2"><i class="fa fa-angle-double-right"></i><?php echo e(__('Privacy Policy')); ?></a></li>
					</ul>
                    </div>
                	</div>
					
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="card overflowhidden l-seagreen">
		        		<div class="body">
		        			<h5 class="text-purple"><?php echo e(__('Accepting Wallet Cash payments in-store')); ?></h5>
			            	<p><?php echo e(__('Outdo your online competition by giving your customers a better way to pay. Modernize your brick-and-mortar store by letting your customers pay with')); ?> <?php echo e(setting('site.site_name')); ?></p>
			            	<a href="https://shop.dxtrader.xyz/" class="btn bg-blue btn-round float-right m-b-3"><?php echo e(__('Download phpWalletCommerce')); ?>

			            	</a>
			            	<div class="clearfix"></div>
			        	</div>
		    		</div>
					
				</div>
				
		</div>
</section>
<section id="footer2">
	<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center ">
					<?php echo setting('footer.footer_text'); ?>

				</div>
			</div>	
		</div>
</section>