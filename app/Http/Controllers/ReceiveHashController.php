<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\ReceiveHash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiveHashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if user has not 2fa verifies
        if (!auth()->user()->enabled_2fs()) {
            return redirect()->route('show2faForm', app()->getLocale());
        }
        if (Auth::user()->currentWallet() == null) {
            return redirect(route('show.currencies', app()->getLocale()));
        }
        $currencies = Currency::where('id', '!=', Auth::user()->currentCurrency()->id)->get();
        return view('requesthash.index')->with('currencies', $currencies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->amount <= 0) {
            flash(__('Please insert an amount greater than 0'), 'danger');
            return back();
        }
        $this->validate($request, [
            'amount'    =>  'required|numeric',
            'hash' =>  'required|string',
        ]);

        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReceiveHash  $receiveHash
     * @return \Illuminate\Http\Response
     */
    public function show(ReceiveHash $receiveHash)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReceiveHash  $receiveHash
     * @return \Illuminate\Http\Response
     */
    public function edit(ReceiveHash $receiveHash)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReceiveHash  $receiveHash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReceiveHash $receiveHash)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReceiveHash  $receiveHash
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReceiveHash $receiveHash)
    {
        //
    }
}
