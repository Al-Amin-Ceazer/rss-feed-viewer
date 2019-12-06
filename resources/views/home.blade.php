@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3>10 most frequent words with their respective counts</h3></div>

                <div class="card-body">
                    @foreach($mostFrequentWords as $word => $count)
                        <button type="button" class="btn btn-sm btn-primary" style="margin-bottom: 10px">{{$word}} <span class="badge">{{$count}}</span></button>
                    @endforeach
                </div>
            </div>
            <hr>

            @foreach($feeds as $feed)
                <div class="card">
                    <div class="card-header"><strong>Title:</strong> {{$feed->title}}</div>

                    <div class="card-body">
                         <div><strong>Author:</strong> {{$feed->author}}</div>
                         <div><strong>Published At:</strong> {{$feed->updated}}</div>
                         <div><strong>Author Uri:</strong> <a href="{{urldecode($feed->authorUri)}}">{{urldecode($feed->authorUri)}}</a></div>
                        <hr>
                        {!! $feed->summary !!}
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
</div>
@endsection
