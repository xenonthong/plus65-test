@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Lucky Draw</h4>
        <hr>
        <div class="col-lg-5">
            <draw-selection
                :prize-types='@json($prizeTypes)'
            />
        </div>
    </div>
@endsection