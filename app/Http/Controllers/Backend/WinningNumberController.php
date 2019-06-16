<?php

namespace App\Http\Controllers\Backend;

use App\Draws\Generator;
use App\Http\Controllers\Controller;
use App\Http\Requests\showWinningNumber;

class WinningNumberController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Http\Requests\showWinningNumber $request
     *
     * @return \App\Models\Number
     */
    public function show(showWinningNumber $request)
    {
        return Generator::generate($request->prize_type);
    }
}
