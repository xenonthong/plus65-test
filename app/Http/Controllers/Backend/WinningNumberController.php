<?php

namespace App\Http\Controllers\Backend;

use App\Draws\Generator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WinningNumberController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Models\Number
     */
    public function show(Request $request)
    {
        return Generator::generate($request->prize_type);
    }
}
