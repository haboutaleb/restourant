<div class="form-group">
	@include('Back.includes.inputs', ['errors'=>$errors,'type'=>'text','name'=>'title','style'=>'form-control form-data','slug'=>'الاسم'])
</div>

<div class="form-group">
	@include('Back.includes.inputs', ['errors'=>$errors,'type'=>'textarea','name'=>'description','style'=>'form-control form-data','slug'=>'الوصف'])
</div>

<div class="form-group">
	@include('Back.includes.inputs', ['errors' => $errors, 'type' => 'image','name' => 'image', 'style' => 'form-control form-data'])
</div>

{{-- <div class="form-group">
	<div class="checkbox checkbox-switchery switchery-lg switchery-double">
		<label>
			<input type="checkbox" name="status" class="switchery" @isset($category) {{ $category->status == 1 ? 'checked' : '' }} @endisset>
			الحاله
		</label>
	</div>	
</div> --}}