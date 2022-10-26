<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\Exchange;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Receive;
use App\Models\Send;
use App\Models\Merchant;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
	public function show(Request $request, $lang, int $id)
	{
		$transaction = Transaction::findOrFail($id);

		switch ($transaction->transactionable_type) {
			case 'App\Models\Sale':

				$sale = Sale::findOrFail($transaction->transactionable_id);
				$purchase = Purchase::findOrFail($sale->purchase_id);
				$client = User::findOrFail($purchase->user_id);
				$merchant = Merchant::findOrFail($sale->merchant_id);
				return view('Transactions.show')
					->with('transaction', $transaction)
					->with('sale', $sale)
					->with('client', $client)
					->with('invoice', json_decode($transaction->json_data))
					->with('merchant', $merchant)
					->with('purchase', $purchase);

				break;
			case 'App\Models\Purchase':
				$purchase = Purchase::findOrFail($transaction->transactionable_id);
				$merchant = Merchant::findOrFail($purchase->merchant_id);
				return view('Transactions.show')
					->with('transaction', $transaction)
					->with('invoice', json_decode($transaction->json_data))
					->with('merchant', $merchant)
					->with('purchase', $purchase);
				break;
			case 'App\Models\Receive':
				# code...
				break;
			case 'App\Models\Send':
				# code...
				break;
			case 'App\Models\Exchange':
				# code...
				break;
			case 'App\Models\Deposit':
				# code...
				break;
			case 'App\Models\Withdrawal':
				# code...
				break;
			case 'App\Models\Voucher':
				# code...
				break;

			default:
				# code...
				break;
		}
	}

	public function deleteMapper(Request $request, $lang)
	{

		$this->validate($request, [
			'tid'	=>	'exists:transactionable,id|required'
		]);

		$transaction = Transaction::where('id', $request->tid)->first();

		if (Auth::user()->id != $transaction->user_id or Auth::user()->role_id != 1) {
			flash(__('Woops, something went wrong'), 'danger');
			return back();
		}

		$delete = str_replace('App\Models\\', 'delete', $transaction->transactionable_type);

		if ($delete == 'deletePurchase') {

			$this->deletePurchase($transaction);
			return back();
		}

		if ($delete == 'deleteSend') {

			$this->deleteSend($transaction);
			return back();
		}
	}

	private function deletePurchase(Transaction $trans)
	{


		$purchase = Purchase::findOrFail($trans->transactionable_id);
		$sale = Sale::findOrFail($purchase->sale_id);

		$trans->delete();
		$purchase->delete();
		$sale->delete();

		flash(__('Transaction deleted'), 'danger');
	}

	private function  deleteSend(Transaction $trans)
	{

		$trans_wallet = Wallet::where('user_id', $trans->user_id)->where('currency_id', $trans->currency_id)->first();

		$send = Send::findOrFail($trans->transactionable_id);
		$receive = Receive::findOrFail($send->receive_id);

		$receive_transaction = Transaction::where('transactionable_type', 'App\Models\Receive')->where('transactionable_id', $receive->id)->first();

		$receive_transaction_wallet = Wallet::where('user_id', $receive_transaction->user_id)->where('currency_id', $receive_transaction->currency_id)->first();

		$trans->transaction_state_id = 2;
		$trans->balance = $trans_wallet->amount;
		$trans->save();
		$send->delete();
		$receive->delete();
		$receive_transaction->transaction_state_id = 2;
		$receive_transaction->balance = $receive_transaction_wallet->amount;
		$receive_transaction->save();

		flash(__('Transaction deleted'), 'danger');
	}

	private function  deleteReceive(Transaction $trans)
	{

		$receive = Send::findOrFail($trans->transactionable_id);
		$send = Receive::findOrFail($receive->send_id);

		$send_transaction = Transaction::where('transactionable_type', 'App\Models\Send')->where('transactionable_id', $send->id)->first();

		$trans->transaction_state_id = 2;
		$trans->save();
		$send->delete();
		$receive->delete();
		$send_transaction->transaction_state_id = 2;
		$send_transaction->save();

		flash(__('Transaction deleted'), 'danger');
	}
}
