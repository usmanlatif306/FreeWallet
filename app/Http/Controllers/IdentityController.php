<?php

namespace App\Http\Controllers;

use App\Services\CoinPaymentService;
use App\Services\IdentityService;
use App\Services\SumSubService;
use App\Services\WalletService;
use CURLFile;
use Illuminate\Http\Request;


class IdentityController extends Controller
{
    public function index(WalletService $service)
    {
        // if user has not 2fa verifies
        if (!auth()->user()->enabled_2fs()) {
            return redirect()->route('show2faForm', app()->getLocale());
        }
        // $service->send_money();

        return view('identity.index');
    }
    public function identify(Request $request, IdentityService $service)
    {
        // $externalUserId = uniqid();
        // $levelName = 'basic-kyc-level';

        // $sumsub = new SumSubService();
        // $applicantId = $sumsub->createApplicant($externalUserId, $levelName);
        // echo "The applicant was successfully created: " . $applicantId . PHP_EOL . '<br/>';

        // // saving image to local drive and getting pull path
        // $imageFile = $request->fornt_image->getClientOriginalName();
        // $filename = pathinfo($imageFile, PATHINFO_FILENAME);
        // $extension = pathinfo($imageFile, PATHINFO_EXTENSION);
        // $imageName = time() . "." . $extension;
        // $request->fornt_image->storeAs("idenifications", $imageName, "public");
        // $path = 'public/storage/idenifications/' . $imageName;

        // $file = str_replace("app\Http\Controllers", "", __DIR__ . $path);

        // $imageId = $sumsub->addDocument($applicantId, $file);
        // echo "Identifier of the added document: " . $imageId . PHP_EOL;
        // exit(1);

        // getting token
        $token = $service->getToken();

        // genreation curl files through CURLFILE method
        $doc_front_image = new CURLFile($_FILES['fornt_image']['tmp_name'], $_FILES['fornt_image']['type'], $_FILES['fornt_image']['name']);
        $doc_back_image = new CURLFile($_FILES['back_image']['tmp_name'], $_FILES['back_image']['type'], $_FILES['back_image']['name']);
        $selfie_image = new CURLFile($_FILES['user_image']['tmp_name'], $_FILES['user_image']['type'], $_FILES['user_image']['name']);

        // changing into array
        $data = array('doc_front_image' => $doc_front_image, 'doc_back_image' => $doc_back_image, 'selfie_image' => $selfie_image);

        // passing the token and data to the curl request and getting response
        $response = $service->identification($token, $data);

        if (isset($response->status) && $response->status === 'Failed') {
            return redirect()->back()->withError($response->message);
        }

        if (isset($response->verification) && $response->verification->passed) {
            auth()->user()->update(['identified' => true]);
            return redirect()->route('addFundsForm', app()->getLocale())->with('success', 'Congratulations! Your identity is marked as verified. You can now proceed.');
        }

        dd($response);
    }


    // identification with camera
    public function identifyWithCamera(Request $request)
    {
        auth()->user()->update(['identified' => true]);
        return redirect()->route('addFundsForm', app()->getLocale())->with('success', 'Congratulations! Your identity is marked as verified. You can now proceed.');
    }
}
