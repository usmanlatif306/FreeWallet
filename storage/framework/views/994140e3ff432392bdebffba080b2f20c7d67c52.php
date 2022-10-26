<script >
var withdrawal_form = new Vue({
	el: '#withdrawal_form',
	data:{
		total: 0
	},
	methods: {
		totalize : function(evt){
			this.total =  (evt.target.value - ( ((<?php echo e($current_method->percentage_fee); ?>/100) * evt.target.value) + <?php echo e($current_method->fixed_fee); ?> )).toFixed(2); 
		}
	}
});
</script>