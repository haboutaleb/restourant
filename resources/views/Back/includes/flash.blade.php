<?php
	$messagesCount = 0;
	foreach (Session::all() as $key => $value) {
		if(strpos($key, 'message') !== false) $messagesCount ++;
	}
?>
@for($i = 0; $i <= $messagesCount ; $i ++)
	<?php $num = $i == 0 ? '' : $i; ?>
	@if(Session::has('message'.$num))

		<div class="alert alert-{{ Session::get('status'.$num) }} alert-dismissible {{ Session::get('status'.$num) == 'success' ? 'alert-arrow-right' : '' }} ">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h4><i class="icon fa fa-ban"></i> Alert!</h4>
			{{ Session::get('message'.$num) }}
        </div>

    @endif
@endfor

@if ($errors->first() || Session::has('custErrors'))

	<div class="alert alert-danger  alert-bordered flash-messages">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">{{ __('titles.close')}}</span></button>
			<p>{{ __('responseMessages.validation-error')}}.</p>
    </div>

@endif
<div id="ajax-messages"></div>