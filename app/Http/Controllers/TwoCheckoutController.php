<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class TwoCheckoutController extends Controller
{
    
    public function buyvoucher(Request $request, $lang)
    {
    	$user = Auth::user();
        $user->currency_id = 1;
        $user->save();
        return view('twocheckout.buyvoucher');

    }

    public function sendRequestToStripe(Request $request, $lang)
    {
    	require_once(__DIR__.'/2Checkout/lib/Twocheckout.php');

    	Twocheckout::privateKey($_ENV['2CHECKOUT_PRIVATE_KEY']);
Twocheckout::sellerId($_ENV['2CHECKOUT_MERCHANT_CODE']);

Twocheckout::verifySSL(false);  // this is set to true by default

// To use your sandbox account set sandbox to true
Twocheckout::sandbox(true);

// All methods return an Array by default or you can set the format to 'json' to get a JSON response.
Twocheckout::format('json');

try {
    $charge = Twocheckout_Charge::auth(array(
        "sellerId" => "901248204",
        "merchantOrderId" => "123",
        "token" => 'MjFiYzIzYjAtYjE4YS00ZmI0LTg4YzYtNDIzMTBlMjc0MDlk',
        "currency" => 'USD',
        "total" => '10.00',
        "billingAddr" => array(
            "name" => 'Testing Tester',
            "addrLine1" => '123 Test St',
            "city" => 'Columbus',
            "state" => 'OH',
            "zipCode" => '43123',
            "country" => 'USA',
            "email" => 'testingtester@2co.com',
            "phoneNumber" => '555-555-5555'
        ),
        "shippingAddr" => array(
            "name" => 'Testing Tester',
            "addrLine1" => '123 Test St',
            "city" => 'Columbus',
            "state" => 'OH',
            "zipCode" => '43123',
            "country" => 'USA',
            "email" => 'testingtester@2co.com',
            "phoneNumber" => '555-555-5555'
        )
    ));
    echo $charge['response']['responseCode'];
} catch (Twocheckout_Error $e) {
    echo $e->getMessage();
}
    }
}
