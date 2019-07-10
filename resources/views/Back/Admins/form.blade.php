<div class="form-group">
	@include('Back.includes.inputs', ['errors'=>$errors,'type'=>'text','name'=>'name','style'=>'form-control form-data','slug'=>'الاسم'])
</div>

<div class="form-group">
	@include('Back.includes.inputs', ['errors'=>$errors,'type'=>'email','name'=>'email','style'=>'form-control form-data','slug'=>'البريد الالكتروني'])
</div>
@php
	$list = ['المسؤول', 'المسؤول الاعلي', 'المشرف'];
@endphp
<div class="form-group">
	@include('Back.includes.inputs', ['errors'=>$errors,'type'=>'select','name'=>'is_super_admin','style'=>'form-control form-data','list'=>$list])
</div>

<div class="form-group">
	@include('Back.includes.inputs', ['errors'=>$errors,'type'=>'text','name'=>'phone','style'=>'form-control form-data','slug'=>'الهاتف'])
</div>

<div class="form-group">
	@include('Back.includes.inputs', ['errors'=>$errors,'type'=>'image','name'=>'image','style'=>'form-control form-data'])
</div>

@if(Request::is('admin-panel/admins/create'))
	<div class="form-group">
		@include('Back.includes.inputs', ['errors'=>$errors,'type'=>'password','name'=>'password','style'=>'form-control form-data','slug'=>'كلمة المرور'])
	</div>
	<div class="form-group">
		@include('Back.includes.inputs', ['errors'=>$errors,'type'=>'password_confirmation','name'=>'password','style'=>'form-control form-data','slug'=>'تاكيد كلمة المرور'])
	</div>
@endif

{{-- <div class="form-group">
	<div class="checkbox checkbox-switchery switchery-lg switchery-double">
		<label>
			<input type="checkbox" name="status" class="switchery" @isset($category) {{ $category->status == 1 ? 'checked' : '' }} @endisset>
			الحاله
		</label>
	</div>	
</div> --}}