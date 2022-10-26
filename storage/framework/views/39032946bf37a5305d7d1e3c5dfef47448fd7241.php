<script >
var withdrawal_form = new Vue({
	el: '#withdrawal_form',
	data:{
		total: 0
	},
	methods: {
		totalize : function(evt){

		  	<?php if(Auth::user()->currentCurrency()->is_crypto == 1 ): ?>
                           this.total =  (evt.target.value - ( ((<?php echo e($transferMethod->withdraw_percentage_fee); ?>/100) * evt.target.value)  )).toFixed(8); 
      	 	<?php else: ?>
                
      	 		this.total =  (evt.target.value - ( ((<?php echo e($transferMethod->withdraw_percentage_fee); ?>/100) * evt.target.value) + <?php echo e($transferMethod->withdraw_fixed_fee); ?> )).toFixed(2); 

           	<?php endif; ?>
			
		}
	}
});
</script>