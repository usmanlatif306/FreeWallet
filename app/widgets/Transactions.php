<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Transactions extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = \App\Models\Transaction::count();
        $string = 'Transactions';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-dollar',
            'title'  => "{$count} {$string}",
            'text'   => __('You have '.$count.' transactions in your database. Click on button below to view all transactions.', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => __('Transactions'),
                'link' => route('voyager.transactionable.index'),
            ],
            'image' => 'static/transactions.jpg',
        ]));
    }
}
