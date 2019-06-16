@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($draws->isNotEmpty())
            <h3>Draw results</h3>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Draw ID</th>
                    <th scope="col">User</th>
                    <th scope="col">Number</th>
                    <th scope="col">Prize Type</th>
                </tr>
                </thead>
                <tbody>
                @foreach($draws as $draw)
                    <tr class="text-capitalize">
                        <th scope="row">{{ $draw->id }}</th>
                        <td>
                            @if ($draw->user->id)
                                {{ $draw->user->name }} (ID: {{ $draw->user->id }})
                            @endif
                        </td>
                        <td>{{ $draw->number }}</td>
                        <td>{{ $draw->type }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <h3>No draw results available.</h3>
        @endif
    </div>
@endsection