<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class TotalDeposits extends AbstractWidget
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
        $count = \App\Models\Deposit::sum('gross');
        $count = \App\Helpers\Money::instance()->value($count);
        $string = 'Total deposited ';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-credit-card',
            'title'  => "{$count} {$string}",
            'text'   => __(' ', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => '',
                'link' => '#',
            ],
            'image' => '',
        ]));
    }
}
