<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeDraw;
use App\Models\Draw;
use App\Models\Number;

class DrawController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.draws.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDraw $request)
    {
        $number = Number::where('value', $request->number)->first();

        return Draw::create([
            'type'    => $request->type,
            'number'  => $number->value,
            'user_id' => $number->user_id,
        ]);
    }
}
