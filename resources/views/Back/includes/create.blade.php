@extends('layouts.layout')

@section('title', ucwords(str()->plural($model[0])))

@section('content')
    <div class="panel panel-flat content">
        <div class="panel-heading">Add new {{ $model[0] }}</div>
        {!! 
            Form::open([
                'url' => url('/admin-panel/'.str()->plural($model[0])), 
                'method' => 'POST', 'class' => 'form-horizontal push-10-t '.str()->plural($model[0]).' ajax create', 'files' => true
            ]) 
        !!}
        <div class="panel-body">
            @include('Back.includes.flash')
            <div class="block block-rounded">
                <div class="block-header bg-smooth-dark col-md-10 col-md-offset-1">

                    @if($model[1] != null)
                        @include('Back.'.ucwords(str()->plural($model[0])).'.form', ['list' => $model[1]])
                    @else
                        @include('Back.'.ucwords(str()->plural($model[0])).'.form')
                    @endif

                </div>
            </div>
        </div>
        <div class="panel-footer">
            <input type="submit" name="submit" class="btn btn-primary" value="حفظ">
        </div>
        {!! Form::close() !!}
    </div>
@stop

@section('script')
	<!-- Theme JS files -->
	{{-- <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/styling/uniform.min.js') }}"></script> --}}
	{{-- <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/styling/switchery.min.js') }}"></script> --}}
	{{-- <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/styling/switch.min.js') }}"></script> --}}
	<!-- /theme JS files -->
	{{-- <script type="text/javascript" src="{{ asset('assets/js/pages/form_checkboxes_radios.js') }}"></script> --}}
@stop