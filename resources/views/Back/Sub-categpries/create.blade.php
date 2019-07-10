@extends('layouts.layout')

@section('title', 'Order')

@section('style')

@endsection

@section('content')
   <div class="row">
    <div class="col-md-12">
        <form action="">
            @include('Back.order.form')
        </form>
    </div>
   </div>
@endsection

@section('script')
<script type="text/javascript" src="{{url('temp/assets/js/plugins/forms/selects/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('temp/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

<script type="text/javascript" src="{{url('temp/assets/js/core/app.js')}}"></script>
<script type="text/javascript" src="{{url('temp/assets/js/pages/form_layouts.js')}}"></script>


<script>
  $('#salon').hide();
  $('#dilevary').hide();

      //@naresh action dynamic childs
    var next = 0;
    $("#add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next+1);
        next = next + 1;
        var newIn = ' <div id="field'+ next +'" name="field'+ next +'"><!-- Text input--><div class="form-group"> <label class="col-md-4 control-label" for="action_id">إسم المنتج</label> <div class="col-md-5"> <input id="item_id" name="item_id" type="text" placeholder="إسم المنتج" class="form-control input-md"> </div></div> <!-- Text input--><div class="form-group"> <label class="col-md-4 control-label" for="action_name">الحجم</label> <div class="col-md-5"> <input id="action_name" name="size[]" type="text" placeholder="الحجم" class="form-control input-md"> </div></div><br><br><!-- File Button --> <div class="form-group"> <label class="col-md-4 control-label" for="action_json">الكمية</label> <div class="col-md-4"> <input id="action_json" name="quantity[]" class="form-control" type="text"> </div></div></div>';
        var newInput = $(newIn);
        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >Remove</button></div></div><div id="field">';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);
            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
    });




    $("#add-more-2").click(function(e){
        e.preventDefault();
        var addto = "#field-2" + next;
        var addRemove = "#field-2" + (next);
        next = next + 1;
        var newIn = ' <div id="field'+ next +'" name="field'+ next +'"><!-- Text input--><div class="form-group"> <label class="col-md-4 control-label" for="action_id">Action Id</label> <div class="col-md-5"> <input id="action_id" name="action_id" type="text" placeholder="" class="form-control input-md"> </div></div><br><br> <!-- Text input--><div class="form-group"> <label class="col-md-4 control-label" for="action_name">Action Name</label> <div class="col-md-5"> <input id="action_name" name="action_name" type="text" placeholder="" class="form-control input-md"> </div></div><br><br><!-- File Button --> <div class="form-group"> <label class="col-md-4 control-label" for="action_json">Action JSON File</label> <div class="col-md-4"> <input id="action_json" name="action_json" class="input-file" type="file"> </div></div></div>';
        var newInput = $(newIn);
        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >Remove</button></div></div><div id="field">';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field-2" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);

            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
    });

    $('#salon1').on('change',function(){

        $('#salon').show();
        $('#dilevary').hide();

    });

    $('#delvary1').on('change',function(){

        $('#salon').hide();
        $('#dilevary').show();

    });
</script>
@endsection
