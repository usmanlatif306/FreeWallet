<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\CurrencyExchangeRate;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{


    public function getExchangeRequestForm(Request $request, $lang, $currency_id = null, $second_currency_id = null)
    {




        $firstCurrency = Currency::find(Auth::user()->currency_id);

        $secondCurrenciesExchanges = CurrencyExchangeRate::with('secondCurrency')->where('first_currency_id', $firstCurrency->id)->get();

        if (count($secondCurrenciesExchanges) == 0) {
            dd('Please Contact the site admin to add currency exchange rates for ' . $firstCurrency->name . ' currency  -> ' . url('/') . '/' . app()->getLocale() . '/update_rates');
        }

        $firstCurrenciesExchages = CurrencyExchangeRate::with('firstCurrency')->select('first_currency_id')->distinct()->get();

        if (count($firstCurrenciesExchages) == 0) {
            dd('Please Contact the site admin to add currency exchange rates ');
        }


        if (is_null($second_currency_id) or !($second_currency_id)) {
            $secondCurrency = $secondCurrenciesExchanges[0]->secondCurrency;
        } else {
            $secondCurrency = Currency::find($second_currency_id);
            if (is_null($secondCurrency)) {
                abort(404);
            }
        }

        if ($firstCurrency->id == $secondCurrency->id) {
            return redirect(url(app()->getLocale() . '/home'));
        }

        if ($secondCurrency == null) {
            return back();
        }



        //Auth::user()->currency_id = $firstCurrency->id;
        //Auth::user()->save();

        if ($secondCurrency->id == Auth::user()->currency_id) {
            $currency = Auth::user()->walletByCurrencyId($firstCurrency->id);
            if ($currency) {
                Auth::user()->currency_id = $firstCurrency->id;
                Auth::user()->save();
            }
            //TODOLOCALE
            return redirect($request->url());
        } else {

            $wallet = Wallet::with('Currency')->where('user_id', Auth::user()->id)->where('currency_id', $secondCurrency->id)->first();

            if ($wallet == null) {
                $wallet = Auth::user()->newWallet($secondCurrency->id);
                flash(__('Your account only has one wallet, please create at least 2 wallets to start swapping'), 'info');
                //return redirect(app()->getLocale().'/transfer/methods');
                return redirect(route('show.currencies', app()->getLocale()));
            }
        }

        $exchange = CurrencyExchangeRate::where('first_currency_id', $firstCurrency->id)->where('second_currency_id', $secondCurrency->id)->first();
        if ($exchange == null) {
            dd('Please Contact the site admin to add exchange rate for ' .  $firstCurrency->name . ' to ' . $secondCurrency->name);
        }

        $show_exchange_rates_form = false;
        $currencies = Currency::all();

        if (Auth::user()->role_id == 1 and !is_null($currencies)) {
            $show_exchange_rates_form = true;
        }

        $update_rates = CurrencyExchangeRate::with('secondCurrency')->where('first_currency_id', $firstCurrency->id)->get();
        return view('exchange.exchangeRequestForm')
            ->with('show_exchange_rates_form', $show_exchange_rates_form)
            ->with('currencies', $currencies)
            ->with('wallet', $wallet)
            ->with('update_rates', $update_rates)
            ->with('exchange', $exchange)
            ->with('secondCurrency', $secondCurrency)
            ->with('firstCurrency', $firstCurrency)
            ->with('secondCurrenciesExchanges', $secondCurrenciesExchanges)
            ->with('firstCurrenciesExchages', $firstCurrenciesExchages);
    }

    public function exchange(Request $request, $lang)
    {
        $this->validate($request, [
            'amount'    =>  'required|numeric|between:0.0001,' . Auth::user()->currentWallet()->amount,
            'exchange_id'   =>  'required|exists:currency_exchange_rates,id'
        ]);

        if (Auth::user()->account_status == 0) {
            flash(__('Your account is under a withdrawal request review proccess. Please wait until your request is complete in a few minutes to continue with your activities.'), 'info');
            return  back();
        }

        $currencyexchange = CurrencyExchangeRate::with('firstCurrency', 'secondCurrency')->find($request->exchange_id);

        $firstWallet = Wallet::where('currency_id', $currencyexchange->firstCurrency->id)->where('user_id', Auth::user()->id)->first();

        $secondWallet = Wallet::where('currency_id', $currencyexchange->secondCurrency->id)->where('user_id', Auth::user()->id)->first();


        if ($currencyexchange->firstCurrency->is_crypto == 1) {
            $first_precision = 8;
        } else {
            $first_precision = 2;
        }

        $firstWallet->amount = bcsub('' . $firstWallet->amount, '' . $request->amount, $first_precision);



        if ($currencyexchange->secondCurrency->is_crypto == 1) {
            $second_precision = 8;
        } else {
            $second_precision = 2;
        }
        $secondCurrencyExchangedValue = bcmul('' . $request->amount, $currencyexchange->exchanges_to_second_currency_value, $second_precision);

        $secondWallet->amount = bcadd('' . $secondWallet->amount, '' . $secondCurrencyExchangedValue,  $second_precision);

        $firstWallet->save();
        $secondWallet->save();

        $exchange = Exchange::create([
            'user_id'   =>  Auth::user()->id,
            'first_currency_id' =>   $currencyexchange->firstCurrency->id,
            'second_currency_id'    =>  $currencyexchange->secondCurrency->id,
            'gross' =>  $request->amount,
            'fee'   =>  0.00,
            'net'   =>  $request->amount,

        ]);

        Auth::User()->RecentActivity()->save($exchange->Transactions()->create([
            'user_id' => Auth::User()->id,
            'entity_id'   =>  $exchange->id,
            'entity_name' =>   $currencyexchange->firstCurrency->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '-',
            'currency_id' =>  $currencyexchange->firstCurrency->id,
            'currency_symbol' =>  $currencyexchange->firstCurrency->symbol,
            'activity_title'    =>  'Currency Exchange',
            'thumb' =>  $currencyexchange->firstCurrency->thumb,
            'gross' =>  $exchange->gross,
            'fee'   =>  $exchange->fee,
            'net'   =>  $exchange->net,
            'balance'   =>  $firstWallet->amount
        ]));

        Auth::User()->RecentActivity()->save($exchange->Transactions()->create([
            'user_id' => Auth::User()->id,
            'entity_id'   =>  $exchange->id,
            'entity_name' =>   $currencyexchange->secondCurrency->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '+',
            'currency_id' =>  $currencyexchange->secondCurrency->id,
            'currency_symbol' =>  $currencyexchange->secondCurrency->symbol,
            'thumb' =>  $currencyexchange->secondCurrency->thumb,
            'activity_title'    =>  'Currency Exchange',
            'gross' =>  $request->amount * $currencyexchange->exchanges_to_second_currency_value,
            'fee'   =>  $exchange->fee,
            'net'   =>  $request->amount * $currencyexchange->exchanges_to_second_currency_value,
            'balance'   =>  $secondWallet->amount
        ]));

        return redirect(app()->getLocale() . '/home');
    }

    public function updateRate(Request $request, $lang)
    {

        $this->validate($request, [
            'second_currency_id' => 'exists:currencies,id|numeric',
            'amount'    =>  'required'
        ]);

        $currency_exchange_rate = CurrencyExchangeRate::where('first_currency_id', Auth::user()->currency_id)->where('second_currency_id', $request->second_currency_id)->first();

        if (is_null($currency_exchange_rate)) {

            CurrencyExchangeRate::create([
                'first_currency_id' => Auth::user()->currency_id,
                'second_currency_id' => $request->second_currency_id,
                'exchanges_to_second_currency_value'    =>  $request->amount

            ]);

            return back();
        }

        $currency_exchange_rate->exchanges_to_second_currency_value = $request->amount;
        $currency_exchange_rate->save();

        return back();
    }

    public function updateRateForm()
    {

        $show_exchange_rates_form = false;
        $currencies = Currency::all();

        if (Auth::user()->role_id == 1 and !is_null($currencies)) {
            $show_exchange_rates_form = true;
        } else {
            return back();
        }

        $update_rates = CurrencyExchangeRate::with('secondCurrency')->where('first_currency_id', Auth::user()->currency_id)->get();
        return view('exchange.ExchangeRates')
            ->with('show_exchange_rates_form', $show_exchange_rates_form)
            ->with('currencies', $currencies)
            ->with('update_rates', $update_rates);
    }
}
