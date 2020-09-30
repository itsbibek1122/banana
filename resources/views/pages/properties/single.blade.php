@extends('frontend.layouts.app')

@section('content')

<!-- SINGLE PROPERTY SECTION -->

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col s12 m8">
                <div class="single-title">
                    <h4 class="single-title">{{ $property->title }}</h4>
                </div>

                <div class="address m-b-30">
                    <i class="small material-icons left">place</i>
                    <span class="font-18">{{ $property->address }}</span>
                </div>

                <div>
                    @if($property->featured == 1)
                    <a class="btn-floating btn-small disabled"><i class="material-icons">star</i></a>
                    @endif

                    <span class="btn btn-small disabled b-r-20">Bedroom: {{ $property->bedroom}} </span>
                    <span class="btn btn-small disabled b-r-20">Bathroom: {{ $property->bathroom}} </span>
                    <span class="btn btn-small disabled b-r-20">Area: {{ $property->area}} Sq Ft</span>
                </div>
            </div>
            <div class="col s12 m4">
                <div>
                    <h4 class="left">${{ $property->price }}</h4>
                    <button type="button" class="btn btn-small m-t-25 right disabled b-r-20"> For
                        {{ $property->purpose }}</button>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col s12 m8">

                @if(!$property->gallery->isEmpty())
                <div class="single-slider">
                    @include('pages.properties.slider')
                </div>
                @else
                <div class="single-image">
                    @if(Storage::disk('public')->exists('property/'.$property->image) && $property->image)
                    <img src="{{Storage::url('property/'.$property->image)}}" alt="{{$property->title}}"
                        class="imgresponsive">
                    @endif
                </div>
                @endif

                <div class="single-description p-15 m-b-15 border2 border-top-0">
                    {!! $property->description !!}
                </div>

                <div class="card-no-box-shadow card">
                    <div class="p-15 grey lighten-4">
                        <h5 class="m-0">Floor Plan</h5>
                    </div>
                    <div class="card-image">
                        @if(Storage::disk('public')->exists('property/'.$property->floor_plan) && $property->floor_plan)
                        <img src="{{Storage::url('property/'.$property->floor_plan)}}" alt="{{$property->title}}"
                            class="imgresponsive">
                        @endif
                    </div>
                </div>

                <div class="card-no-box-shadow card">
                    <div class="p-15 grey lighten-4">
                        <h5 class="m-0">Location</h5>
                    </div>
                    <div class="card-image">
                        <div id="map"></div>
                    </div>
                </div>

                @if($videoembed)
                <div class="card-no-box-shadow card">
                    <div class="p-15 grey lighten-4">
                        <h5 class="m-0">Video</h5>
                    </div>
                    <div class="card-image center m-t-10">
                        {!! $videoembed !!}
                    </div>
                </div>
                @endif

                <div class="card-no-box-shadow card">
                    <div class="p-15 grey lighten-4">
                        <h5 class="m-0">Near By</h5>
                    </div>
                    <div class="single-narebay p-15">
                        {!! $property->nearby !!}
                    </div>
                </div>

            </div>
            {{-- End ./COL M8 --}}

            <div class="col s12 m4">
                <div class="clearfix">

                    <div>
                        <ul class="collection with-header m-t-0">
                            <li class="collection-header grey lighten-4">
                                <h5 class="m-0">Contact with Agent</h5>
                            </li>
                            <li class="collection-item p-0">
                                @if($property->user)
                                <div class="card horizontal card-no-shadow">
                                    <div class="card-image p-l-10 agent-image">
                                        <img src="{{Storage::url('users/'.$property->user->image)}}"
                                            alt="{{ $property->user->username }}" class="imgresponsive">
                                    </div>
                                    <div class="card-stacked">
                                        <div class="p-l-10 p-r-10">
                                            <h5 class="m-t-b-0">{{ $property->user->name }}</h5>
                                            <strong>{{ $property->user->email }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-l-10 p-r-10">
                                    <p>{{ $property->user->about }}</p>
                                    <a href="{{ route('agents.show',$property->agent_id) }}"
                                        class="profile-link">Profile</a>
                                </div>
                                @endif
                            </li>

                            <li class="collection agent-message">
                                <form class="agent-message-box" action="" method="POST">
                                    @csrf
                                    <input type="hidden" name="agent_id" value="{{ $property->user->id }}">
                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                    <input type="hidden" name="property_id" value="{{ $property->id }}">

                                    <div class="box">
                                        <input type="text" name="name" placeholder="Your Name">
                                    </div>
                                    <div class="box">
                                        <input type="email" name="email" placeholder="Your Email">
                                    </div>
                                    <div class="box">
                                        <input type="number" name="phone" placeholder="Your Phone">
                                    </div>
                                    <div class="box">
                                        <textarea name="message" placeholder="Your Msssage"></textarea>
                                    </div>
                                    <div class="box">
                                        <button id="msgsubmitbtn" class="btn waves-effect waves-light w100 indigo"
                                            type="submit">
                                            SEND
                                            <i class="material-icons left">send</i>
                                        </button>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <ul class="collection with-header">
                            <li class="collection-header grey lighten-4">
                                <h5 class="m-0">City List</h5>
                            </li>
                            @foreach($cities as $city)
                            <li class="collection-item p-0">
                                <a class="city-list" href="{{ route('property.city',$city->city_slug) }}">
                                    <span>{{ $city->city }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <ul class="collection with-header">
                            <li class="collection-header grey lighten-4">
                                <h5 class="m-0">Related Properties</h5>
                            </li>
                            @foreach($relatedproperty as $property_related)
                            <li class="collection-item p-0">
                                <a href="{{ route('property.show',$property_related->id) }}">
                                    <div class="card horizontal card-no-shadow m-0">
                                        @if($property_related->image)
                                        <div class="card-image">
                                            <img src="{{Storage::url('property/'.$property_related->image)}}"
                                                alt="{{$property_related->title}}" class="imgresponsive">
                                        </div>
                                        @endif
                                        <div class="card-stacked">
                                            <div class="p-l-10 p-r-10 indigo-text">
                                                <h6 title="{{$property_related->title}}">
                                                    {{ Str::limit( $property_related->title, 18 ) }}</h6>
                                                <strong>&dollar;{{$property_related->price}}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@section('scripts')

<script>
    $(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // MESSAGE
            $(document).on('submit','.agent-message-box',function(e){
                e.preventDefault();

                var data = $(this).serialize();
                var url = "{{ route('property.message') }}";
                var btn = $('#msgsubmitbtn');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    beforeSend: function() {
                        $(btn).addClass('disabled');
                        $(btn).empty().append('LOADING...<i class="material-icons left">rotate_right</i>');
                    },
                    success: function(data) {
                        if (data.message) {
                            M.toast({html: data.message, classes:'green darken-4'})
                        }
                    },
                    error: function(xhr) {
                        M.toast({html: xhr.statusText, classes: 'red darken-4'})
                    },
                    complete: function() {
                        $('form.agent-message-box')[0].reset();
                        $(btn).removeClass('disabled');
                        $(btn).empty().append('SEND<i class="material-icons left">send</i>');
                    },
                    dataType: 'json'
                });

            })
        })
</script>
@endsection