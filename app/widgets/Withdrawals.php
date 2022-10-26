<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Withdrawals extends AbstractWidget
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
        $count = \App\Models\Withdrawal::where('transaction_state_id', '3')->count();
        $string = 'Withdrawal Requests';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-external',
            'title'  => "{$count} {$string}",
            'text'   => __('You have '.$count.' Withdrawal requests. Click on button below to view all Withdrawals.', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => __('Withdrawals'),
                'link' => route('voyager.withdrawals.index'),
            ],
            'image' => 'static/withdrawals.jpg',
        ]));
    }
}
