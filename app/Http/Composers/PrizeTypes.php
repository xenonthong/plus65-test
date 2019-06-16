<?php

namespace App\Http\Composers;

use Illuminate\View\View;

class PrizeTypes
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('prizeTypes', \App\Enums\PrizeTypes::toArray());
    }
}