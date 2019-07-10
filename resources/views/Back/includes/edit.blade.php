@extends('layouts.layout')

@section('title', ucwords(str()->plural($model[0])))

@section('content')
    <div class="panel panel-flat content">
        <div class="panel-heading">Edit {{ ucfirst($model[0]) }} {{ isset($editor->name) ? $editor->name : $editor->title }}</div>
        {!! 
            Form::model($editor,[
                'url' => url('/admin-panel/'.str()->plural($model[0]).'/'.$editor->id), 
                'method' => 'PUT','class' => 'form-horizontal '.str()->plural($model[0]).' ajax edit',
                'files' => true
            ])
        !!}
        <div class="panel-body">
            @include('Back.includes.flash')
            <div class="block block-rounded">
                <div class="block-header bg-smooth-dark col-md-10 col-md-offset-1">
                    
                    @if($model[1] != null)
                        @include('Back.'.ucfirst(str()->plural($model[0])).'.form', ['list' => $model[1]])
                    @else
                        @include('Back.'.ucfirst(str()->plural($model[0])).'.form')
                    @endif

                </div>
            </div>
        </div>
        <div class="panel-footer">
            <input type="submit" name="submit" class="btn btn-primary" value="Save">
        </div>
        {!! Form::close() !!}
    </div>
@stop