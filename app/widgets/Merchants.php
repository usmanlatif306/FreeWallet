<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Merchants extends AbstractWidget
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
        $count = \App\Models\Merchant::count();
        $string = 'Merchants';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-wallet',
            'title'  => "{$count} {$string}",
            'text'   => __('You have '.$count.' Merchants in your database. Click on button below to view all Merchants.', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => __('Merchants'),
                'link' =>  route('voyager.merchants.index'),
            ],
            'image' => '',
        ]));
    }
}
