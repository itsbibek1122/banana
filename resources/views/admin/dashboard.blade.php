@extends('backend.layouts.app')

@section('title', 'Dashboard')

@push('styles')

@endpush


@section('content')

<div class="block-header">
    <h2>DASHBOARD</h2>
</div>

<!-- Widgets -->
<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink hover-expand-effect">
            <div class="icon">
                <i class="material-icons">playlist_add_check</i>
            </div>
            <div class="content">
                <div class="text">TOTAL PROPERTY</div>
                <div class="number count-to" data-from="0" data-to="{{ $propertycount }}" data-speed="15"
                    data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-orange hover-expand-effect">
            <div class="icon">
                <i class="material-icons">person_add</i>
            </div>
            <div class="content">
                <div class="text">TOTAL USER</div>
                <div class="number count-to" data-from="0" data-to="{{ $usercount }}" data-speed="1000"
                    data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Widgets -->

<div class="row clearfix">
    <!-- RECENT PROPERTIES -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <h2>RECENT PROPERTIES</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>City</th>
                                <th><i class="material-icons small">star</i></th>
                                <th>Manager</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($properties as $key => $property)
                            <tr>
                                <td>{{ ++$key }}.</td>
                                <td>
                                    <span title="{{ $property->title }}">
                                        {{ Str::limit($property->title, 10) }}
                                    </span>
                                </td>
                                <td>&dollar;{{ $property->price }}</td>
                                <td>{{ $property->city }}</td>
                                <td>
                                    @if($property->featured == 1)
                                    <span class="label bg-green">F</span>
                                    @endif
                                </td>
                                <td>{{ strtok($property->user->name, " ")}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# RECENT PROPERTIES -->
</div>

<div class="row clearfix">
    <!-- USER LIST -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <h2>USER LIST</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                            <tr>
                                <td>{{ ++$key }}.</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# USER LIST -->
</div>


@endsection

@push('scripts')

<!-- Jquery CountTo Plugin Js -->
<script src="{{ asset('backend/plugins/jquery-countto/jquery.countTo.js') }}"></script>

<!-- Sparkline Chart Plugin Js -->
<script src="{{ asset('backend/js/pages/index.js') }}"></script>

@endpush