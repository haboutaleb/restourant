@if($type == 'password_confirmation')

	<div class="col-xs-{{ isset($col) ? $col : '12' }} {{ $errors->first($name , 'has-error') }}">
		<div class="form-valid floating">
			<label for="password_confirmation">{{ ucwords($slug) }}</label>
			{!! Form::password('password_confirmation', ['class'=>'form-control form-data','id' => 'password_confirmation']) !!}
		</div>
		{!! $errors->first('password' , '<div class="help-block text-right animated fadeInDown val-error">:message</div>') !!}
	</div>

@elseif($type == 'password')

	<div class="col-xs-{{ isset($col) ? $col : '12' }} {{ $errors->first($name , 'has-error') }}">
		<div class="form-valid floating">
			<label for="{{ $name }}">{{ ucwords($slug) }}</label>
			{!! Form::password($name, ['class'=>'form-control form-data','id' => $name]) !!}
		</div>
		{!! $errors->first('password' , '<div class="help-block text-right animated fadeInDown val-error">:message</div>') !!}
	</div>

@elseif($type == 'select')

	<div class="col-xs-{{ isset($col) ? $col : '12' }} {{ $errors->first($name , 'has-error') }}">
		<div class="form-valid floating">
			<label for="{{ $name }}">{{ ucwords(explode('_', $name)[0]) }}</label>
			{!! Form::select($name, $list, null, ['class'=>'form-control form-data','id' => $name]) !!}
		</div>
		{!! $errors->first($name , '<div class="help-block text-right animated fadeInDown val-error">:message</div>') !!}
	</div>

@elseif($type == 'image')

	<div class="col-xs-{{ isset($col) ? $col : '12' }} {{ $errors->first('image' , 'has-error') }}">
		<div class="row img-media">
			<div class="col-xs-12">
				<div class="form-valid">
					<label for="image">الصورة</label>
					<input type="file" class="{{ $style }}" id="image" accept="image/*" name="image">
					{!! $errors->first('image', '<div class="help-block text-right animated fadeInDown val-error">:message</div>') !!}
				</div>
			</div>
		</div>
	</div>

@elseif($type == 'text')

	<div class="col-xs-{{ isset($col) ? $col : '12' }} {{ $errors->first($name , 'has-error') }}">
		<div class="form-valid floating">
			<label for="{{ $name }}">{{ ucwords($slug) }}</label>
			{!! Form::text($name, null, ['class'=>$style,'id' => $name]) !!}
			{!! $errors->first($name , '<div class="help-block text-right animated fadeInDown val-error">:message</div>') !!}
		</div>
	</div>

@else

	<div class="col-xs-{{ isset($col) ? $col : '12' }} {{ $errors->first($name , 'has-error') }}">
		<div class="form-valid floating">
			<label for="{{ $name }}">{{ isset($slug) ? ucwords($slug) : ucwords(explode('_', $name)[0]) }}</label>
			{!! Form::{$type}($name, null, ['class'=>$style,'id' => $name]) !!}
			{!! $errors->first($name , '<div class="help-block text-right animated fadeInDown val-error">:message</div>') !!}
		</div>
	</div>

@endif