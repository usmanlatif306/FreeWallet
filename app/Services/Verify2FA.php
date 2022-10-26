<?php

namespace App\Services;

class Verify2FA
{
    public function validate($token)
    {
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
        $valid = $google2fa->verifyKey(auth()->user()->loginSecurity->google2fa_secret, $token);

        return $valid;
    }
}
