<?php

namespace App\Http\Composers;

use App\Models\Draw;
use Illuminate\View\View;

class DrawResults
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
        $draws = Draw::with(['user'])
                     ->orderBy('created_at', 'desc')
                     ->take(6)
                     ->get();

        $view->with('draws', $draws);
    }
}