<?php

namespace App;

use App\Models\Wallet;
use Storage;
use App\Models\Ticketcomment;
use App\Models\Currency;
use App\Services\BlockApiService;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;
    use Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'whatsapp', 'phonenumber', 'first_name', 'last_name', 'verified', 'identified', 'role_id', 'settings', 'merchant', 'currency_id', 'social', 'account_status', 'verification_token', 'balance', 'json_data',   'is_ticket_admin', 'identity_verified', 'wallet_id'
    ];

    protected $with = ['profile'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne(\App\Models\Profile::class);
    }

    public function RecentActivity()
    {
        return $this->hasMany(\App\Models\Transaction::class);
    }

    public function loginSecurity()
    {
        return $this->hasOne(\App\LoginSecurity::class);
    }

    public function balance()
    {
        return $this->currentWallet()->amount;
    }

    public function walletBalance()
    {
        return 0.00;
        // return (new BlockApiService())->getAddressBalance($this->address());
    }

    public function address()
    {
        return $this->currentWallet()->blockio_address;
    }

    public function enabled_2fs()
    {
        if ($this->loginSecurity && $this->loginSecurity->google2fa_enable === 1) {
            return true;
        }
        return false;
    }

    public function isAdministrator()
    {
        if ($this->role_id == 1) {
            return true;
        }
        return false;
    }

    public function currentCurrency()
    {
        if (!is_null($this->currentWallet())) {
            return $this->currentWallet()->currency;
        }

        $currency = Currency::first();
        $wallet = $this->newWallet($currency->id);

        $this->currency_id  =  $currency->id;
        $this->save();
        return $currency;
    }

    public function walletsCollection()
    {
        return $this->hasMany(\App\Models\Wallet::class);
    }

    public function wallets()
    {

        $collection = $this->walletsCollection()->with('Currency')->with('TransferMethod')->where('id', '!=', $this->wallet_id)->where('transfer_method_id', '!=', null)->get();

        foreach ($collection as $key => $value) {
            if (is_null($value->currency)) {
                $collection->forget($key);
            }
        }

        return $collection;
    }

    public function currentWallet()
    {

        // check if the user curency_id property is an existing currency id
        // if it returns NULL that mean the currency was deleted and the user is using an obsolet currency as a default currency

        if (Wallet::where('id', $this->wallet)->first() != NULL) {

            //check if the user has a wallet on that currency if true return that wallet, else create a new wallet on that currency

            $currentWallet = Wallet::with('Currency')->where('id', $this->wallet_id)->first();

            if ($currentWallet != NULL) {

                return $currentWallet;
            } else {
                // The currency exists in the database but the user does not have a wallet on that currency.
                //Create a new wallet on that currency and  return it
            }
        }

        $currency = Currency::orderBy('id', 'asc')->first();
        $wallet = $this->newWallet($currency->id);

        $this->currency_id  =  $currency->id;
        $this->save();
        return Wallet::with('Currency')->where('id', $this->wallet_id)->where('user_id', $this->id)->first();
    }

    public function currentWalletBalance()
    {
        return $this->currentWallet()->amount;
    }

    public function walletByCurrencyId($id)
    {
        if (!is_null($this->walletsCollection()->with('Currency')->where('currency_id', $id)->first())) {
            return $this->walletsCollection()->with('Currency')->where('currency_id', $id)->first();
        }
        return $this->newWallet($id);
    }

    public function newWallet($currency_id)
    {

        $wallet = Wallet::where('user_id', $this->id)->where('currency_id', $currency_id)->first();

        if (!is_null($wallet)) {
            return $wallet;
        }

        // $currency = Currency::findOrFail($currency_id);

        // return Wallet::create([
        //     'is_crypto' =>  $currency->is_crypto,
        //     'user_id'   =>  $this->id,
        //     'currency_id'   =>  $currency_id,
        //     'amount'    =>  0,
        // ]);
    }

    public function getBalanceAttribute($value)
    {
        return $this->currentWalletBalance();
    }

    public function setBalanceAttribute($value)
    {
        $wallet = $this->currentWallet();
        $wallet->amount = $value;
        $wallet->save();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function avatar()
    {
        return $this->avatar;
    }
    public function isActivated()
    {
        return (bool)$this->verified;
    }

    public function canImpersonate()
    {
        // For example
        return $this->role_id == 1;
    }
}
