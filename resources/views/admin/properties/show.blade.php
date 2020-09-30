@extends('backend.layouts.app')

@section('title', 'Show Property')

@push('styles')


@endpush


@section('content')

<div class="block-header"></div>

<div class="row clearfix">

    <div class="col-lg-8 col-md-4 col-sm-12 col-xs-12">
        <div class="card">

            <div class="header bg-indigo">
                <h2>SHOW PROPERTY</h2>
            </div>

            <div class="header">
                <h2>
                    {{$property->title}}
                    <br>
                    <small>Posted By <strong>{{$property->user->name}}</strong> on
                        {{$property->created_at->toFormattedDateString()}}</small>
                </h2>
            </div>

            <div class="header">
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Price : </strong>
                        <span class="right"> &dollar;{{$property->price}}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Bedroom : </strong>
                        <span class="right">{{$property->bedroom}}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Bathroom : </strong>
                        <span class="right">{{$property->bathroom}}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>City : </strong>
                        <span class="right">{{$property->city}}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Address : </strong>
                        <span class="left">{{$property->address}}</span>
                    </li>
                </ul>
            </div>

            <div class="body">
                <h5>Description</h5>
                {!!$property->description!!}
            </div>

        </div>

        @if($property->floor_plan)
        <div class="card">
            <div class="header">
                <h2>FLOOR PLAN</h2>
            </div>
            @if($property->floor_plan && $property->floor_plan != 'default.png')
            <div class="body">
                <img class="img-responsive" src="{{Storage::url('property/'.$property->floor_plan)}}"
                    alt="{{$property->title}}">
            </div>
            @endif
        </div>
        @endif

        @if($videoembed)
        <div class="card">
            <div class="header">
                <h2>PROPERTY VIDEO</h2>
            </div>
            <div class="body text-center">
                {!! $videoembed !!}
            </div>
        </div>
        @endif

        @if(!$property->gallery->isEmpty())
        <div class="card">
            <div class="header bg-red">
                <h2>GALLERY IMAGE</h2>
            </div>
            <div class="body">
                <div class="gallery-box">
                    @foreach($property->gallery as $gallery)
                    <div class="gallery-image">
                        <img class="img-responsive" src="{{Storage::url('property/gallery/'.$gallery->name)}}"
                            alt="{{$property->title}}">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-cyan">
                <h2>TYPE</h2>
            </div>
            <div class="body">
                <strong class="label bg-red">{{$property->type}}</strong> for <strong
                    class="label bg-blue">{{$property->purpose}}</strong>
            </div>
        </div>

        <div class="card">
            <div class="header bg-amber">
                <h2>FEATURED IMAGE</h2>
            </div>
            <div class="body">

                <img class="img-responsive thumbnail" src="{{Storage::url('property/'.$property->image)}}"
                    alt="{{$property->title}}">

                <a href="{{route('admin.properties.index')}}" class="btn btn-danger btn-lg waves-effect">
                    <i class="material-icons left">arrow_back</i>
                    <span>BACK</span>
                </a>
                <a href="{{route('admin.properties.edit',$property->slug)}}" class="btn btn-info btn-lg waves-effect">
                    <i class="material-icons">edit</i>
                    <span>EDIT</span>
                </a>

            </div>
        </div>
    </div>

</div>


@endsection