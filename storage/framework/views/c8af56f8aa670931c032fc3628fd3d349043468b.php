

<?php $__env->startSection('content'); ?>

<div class="row">
	   <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	   <div class="col-md-9 " >
	   	<div class="card">
		    <div class="header">
		        <h2><strong>Integration</strong> Data</h2>
		        <ul class="header-dropdown">
		            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
		                <ul class="dropdown-menu dropdown-menu-right slideUp float-right">
		                    <li><a href="javascript:void(0);">Edit</a></li>
		                    <li><a href="javascript:void(0);">Delete</a></li>
		                    <li><a href="javascript:void(0);">Report</a></li>
		                </ul>
		            </li>
		            <li class="remove">
		                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
		            </li>
		        </ul>
		    </div>
		    <div class="body">
               <p><span class="text-primary">Merchant Key : </span><?php echo e($merchant->merchant_key); ?> </p>
			   	<p><span class="text-primary">Merchant ID : </span><?php echo e($merchant->id); ?></p>
			   	<p><span class="text-primary">Merchant Currency Code : </span><?php echo e($merchant->currency->code); ?></p>
			   	<p><span class="text-primary">Merchant Currency Symbol : </span><?php echo e($merchant->currency->symbol); ?></p>
			   	<p><span class="text-primary">Merchant Request URL : </span><?php echo e(url('/')); ?>/purchase/link</p>
			   	<p><span class="text-primary">Merchant Transaction Status URL : </span><?php echo e(url('/')); ?>/request/status</p>
			   <div class="clearfix"></div>  
		    </div>
		</div>
	   	
	   	<div class="clearfix"></div>

	   	<div class="card">
    <div class="header">
        <h2><strong>How to proceed with your Merchant API Integration</strong> </h2>
        <ul class="header-dropdown">
            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                <ul class="dropdown-menu dropdown-menu-right slideUp float-right">
                    <li><a href="javascript:void(0);">Edit</a></li>
                    <li><a href="javascript:void(0);">Delete</a></li>
                    <li><a href="javascript:void(0);">Report</a></li>
                </ul>
            </li>
            <li class="remove">
                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
            </li>
        </ul>
    </div>
    <div class="body">
                                
        
		<h5><strong>Step 1:</strong></h5>
	   	<div class="alert alert-info mb-5">
	   		<p>Send a CURL POST request that contains <strong><small>(string) => </small>'merchant_key'</strong>, <strong><small>(array) => </small>'invoice'</strong>, and <strong><small>(string) => </small> 'currency_code'</strong> variables to  <kbd><?php echo e(url('/')); ?>/purchase/link</kbd>. As a response you get an array containing the link to the checkout page
	   		</p>
	   		<p class="">The <strong>'invoice'</strong> array must contain the keys [ items, invoice_id, 'invoice_description', total, return_url, cancel_url] and must be converted into  a Json format before making the request.
	   		</p>
	   		<p class="mb-0 ">
	   			<pre class="mb-0  p-5 br-2 bg-white text-info">$invoice['items'] = [
    [
        'name' => 'Product 1',
        'price' => (float)20.000,
        'desciption'    =>  'Product 1 description',
        'qty' => 1
    ],
    [
        'name' => 'Product 2',
        'price' => (float)10.00,
        'desciption'    =>  'Product 2 description',
        'qty' => 1
    ],
    [
        'name' => 'Product 3',
        'price' => (float)10.00,
        'desciption'    =>  'Product 3 description',
        'qty' => 1
    ]
];

$invoice['invoice_id'] = rand(1,50); // should be the same invoice id as the one in your store database
$invoice['invoice_description'] = "Order with Invoice ".  $invoice['invoice_id'] ;
$invoice['total'] = 40.00;
$invoice['return_url'] = url('pay/success/?');
$invoice['cancel_url'] = url('pay/cancel');

$invoice = json_encode($invoice);
	   			</pre>
	   		</p>
            <p>
                The payment request for this merchant should look like the example below:
            </p>
                <div>
<pre class="mb-0 bg-dark text-white  p-5 br-2">
    $post = array(
        'merchant_key'=> '<?php echo e($merchant->merchant_key); ?>',
        'invoice'=> $invoice,
        'currency_code' =>  '<?php echo e($merchant->currency->code); ?>'
        );

        

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, '<?php echo e(url('/')); ?>/purchase/link' );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $response = json_decode(curl_exec($ch),true);

        curl_close($ch);
            </pre>
        </div>
	   	</div>
	   
	   	<h5 class="mt-5"><strong>Step 2:</strong></h5>
	   	<div class="alert alert-info mb-5">
	   		<p class="mb-0">Once you’ve got the response with the link in your website,  redirect your user to the received link. The user will be asked to log in and pay the invoice. 
	   		</p>
                <div class="mt-5">
<pre class="mb-0 bg-dark text-white  p-5 br-2">
        // var_dump($response);

        if ($response['status'] == true) {
           //if response status is true, that means we have a link and we redirect the user to <?php echo e(setting('site.site_name')); ?>

           header('Location: '.$response['link'].'');
        }else{
            var_dump($response);
        }
            </pre>
        </div>
	   	</div>
	  
	   	<h5 class="mt-5"><strong>Step 3:</strong></h5>
	   	<div class="alert alert-info mb-5">
	   		<p class="mb-0"> When the user pays the invoice, he's redirected back to the URL specified in $invoice['return_url'] with a token as a query string.<br> Then in your website, use that token to make another CURL POST request to phpWallet to check if the token is valid or not. by comparing the merchant id from the token and your merchant id.</br> You can even check if the invoice from the token is the same as the invoice from your website database and mark your order as completed.	   			
	   		</p>
                <div class="mb-5 mt-5">
<pre class="mb-0 bg-dark text-white  p-5 br-2">
        
        if (isset($_GET['token']) and !is_null($_GET['token'])) {
        
            $post = array(
            'merchant_key'=> '<?php echo e($merchant->merchant_key); ?>',
            'token'=> $_GET['token']
            );


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, '<?php echo e(url('/')); ?>/request/status' );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            //var_dump(curl_exec($ch));
            $response = json_decode(curl_exec($ch),true);

            curl_close($ch);

            // var_dump($response);

            if ($response['status'] == true) {

                if ($response['data']['entity_id'] == $this->phpWallet_merchant_id) {
                   
                    // Handle your websites code here
                }else{
                    dd('invalid_merchant_id');
                }
            }else{
                var_dump($response);
            }
        }
            </pre>
        </div>
	   	</div>
	   
	 </div>
</div>
	   	
	   	
	   </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>