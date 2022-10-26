<script >
var withdrawal_form = new Vue({
	el: '#withdrawal_form',
	data:{
		total: 0
	},
	methods: {
		totalize : function(evt){

		  	@if(Auth::user()->currentCurrency()->is_crypto == 1 )
                           this.total =  (evt.target.value - ( (({{$transferMethod->withdraw_percentage_fee}}/100) * evt.target.value)  )).toFixed(8); 
      	 	@else
                
      	 		this.total =  (evt.target.value - ( (({{$transferMethod->withdraw_percentage_fee}}/100) * evt.target.value) + {{$transferMethod->withdraw_fixed_fee}} )).toFixed(2); 

           	@endif
			
		}
	}
});
</script>