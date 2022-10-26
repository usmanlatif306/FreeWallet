<script >
var withdrawal_form = new Vue({
	el: '#exchange_form',
	data:{
		total: 0,
		rate: <?php echo e($exchange->exchanges_to_second_currency_value); ?>

	},
	methods: {
		exchange : function(evt){ 
			this.total =  (evt.target.value * this.rate); 
		} 
	}
});
</script>