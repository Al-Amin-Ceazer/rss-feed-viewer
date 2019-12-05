@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach($feeds as $feed)
                <div class="card">
                    <div class="card-header">{{$feed->title}}</div>

                    <div class="card-body">
                        {!! $feed->summary !!}
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
</div>
@endsection
