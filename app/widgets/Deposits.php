<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Deposits extends AbstractWidget
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
        $count = \App\Models\Deposit::where('transaction_state_id', '3')->count();
        $string = 'Deposits waiting a review';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-book',
            'title'  => "{$count} {$string}",
            'text'   => __('You have '.$count.' Deposits in the review queue. Click on button below to view all Deposits.', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => __('Deposits'),
                'link' => route('voyager.deposits.index'),
            ],
            'image' => 'static/deposits.jpg',
        ]));
    }
}
