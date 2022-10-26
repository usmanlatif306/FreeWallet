<ion-menu side="start" type="overlay" menu-id="first">
  
  <ion-content>
    <img src="https://ionicframework.com/docs/demos/api/slides/slide-4.png" alt="">
    <ion-item-divider>
            <ion-label>
              <?php echo e(__('Menu')); ?>

            </ion-label>
          </ion-item-divider>
    <ion-list>
      <ion-item lines="none">
        <ion-icon name="outlet" slot="start" color="primary"></ion-icon><ion-anchor color="dark"  href="<?php echo e(url('/')); ?>/my_vouchers">Load a voucher</ion-anchor>
      </ion-item>
      <ion-item lines="none">
      	<ion-icon name="paper" slot="start" color="primary"></ion-icon><ion-anchor color="dark" href="<?php echo e(url('/')); ?>" > My Transactions</ion-anchor>
      </ion-item>
      <ion-item lines="none">
        <ion-icon name="download" slot="start" color="primary"></ion-icon><ion-anchor color="dark" href="<?php echo e(url('/')); ?>/withdrawal/request">Request a Payout</ion-anchor>
      </ion-item>
      <ion-item lines="none">
        <ion-icon name="pricetag" slot="start" color="primary"></ion-icon><ion-anchor color="dark" href="<?php echo e(url('/')); ?>/withdrawals">Payouts</ion-anchor>
      </ion-item>
      <ion-item lines="none">
        <ion-icon name="save" slot="start" color="primary"></ion-icon><ion-anchor color="dark"  href="<?php echo e(url('/')); ?>/mydeposits">Deposits</ion-anchor>
      </ion-item>
      <ion-item lines="none">
        <ion-icon name="headset" slot="start" color="primary"></ion-icon><ion-anchor color="dark">Support</ion-anchor>
      </ion-item>
      <ion-item lines="none">
        <ion-icon name="key" slot="start" color="primary"></ion-icon><ion-anchor color="dark" href="<?php echo e(url('/')); ?>/unlog">Log Out</ion-anchor>
      </ion-item>
    </ion-list>
  </ion-content>
</ion-menu>