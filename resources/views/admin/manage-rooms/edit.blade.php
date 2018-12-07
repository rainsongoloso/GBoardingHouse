 {!! Form::open(array('url' => url('manage-rooms/'.$room->id), 'enctype' => 'multipart/form-data', 'method' => 'PATCH', 'id' => 'edit-users-form', 'files' => true)) !!}
 
    {{csrf_field()}}

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="name" class="font-weight-bold text-primary">Room Image</label>
            <div class="col-md-12 text-center">
                @if($room->room_image)
                <img src="images/room_image/{{$room->room_image}}" align="img" style="min-width: 150px; height: 150px; display: inline-block; float: none;box-shadow: 0px 0px 0px 2px #eee;" id="prev_img">
                @else
                <img src="{{ url('images/img_holder.png') }}" align="img" style="min-width: 150px; height: 150px; display: inline-block; float: none;box-shadow: 0px 0px 0px 2px #eee;" id="prev_img">
                @endif
            </div>
            <div class="col-md-12 text-center">
                <label class="mt-1" for="room_image">
                    <input type="file" name="room_image" id="room_image" class="room_image" style="display: none;">
                    <div class="btn btn-success upload_btn" id="upload_btn">Change Photo</div>
                </label>
            </div>
        </div>

        <div class="form-group col-md-5">
            <label for="roomno">Room No.</label>
            <input id="roomno" type="text" name="room_no" class="form-control" required value="{{ $room->room_no }}">
        </div>

        <div class="form-group col-md-3">
            <label for="status">Status</label>
            <select class="custom-select" id="status" name="status">
                <option value="Available" {{$room->status == 'Available' ? 'selected':''}}>Available</option>
                <option value="Unavailable" {{$room->status == 'Unavailable' ? 'selected':''}}>Unavailable</option>
                <option value="Occupied" {{$room->status == 'Occupied' ? 'selected':''}}>Occupied</option>
                <option value="Full" {{$room->status == 'Full' ? 'selected':''}}>Full</option>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label for="type">Type</label>
            <select class="custom-select" id="type" name="type">
                <option value="Bed Spacer" {{$room->type == 'Bed Spacer' ? 'selected':''}}>Bed Spacer</option>
                <option value="Private" {{$room->type == 'Private' ? 'selected':''}}>Private</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="rate">Rate</label>
            <input id="rate" type="text" name="rate" class="form-control" value="{{$room->rate}}" required>
        </div>

        <div class="form-group col-md-6">
            <label for="max_capacity">Max Capacity</label>
            <input id="max_capacity" type="number" name="max_capacity" class="form-control" required value="{{$room->max_capacity}}">
        </div>
    </div>     

    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="description">Description</label>
            <textarea id="description" type="text" name="description" class="form-control" placeholder="Description" required>
                {{$room->description}}
            </textarea>
        </div>
    </div>

   <!--  <div class="form-row">
       <div class="form-group col-md-6">
           <label for="image">Room Image</label>
           <input type="file" id="image" name="room_image" class="form-control-file">
           <span class="help-text text-danger"></span>
       </div>
   </div> -->

    <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary update-btn">Update</button>
    </div>
</form>


<script type="text/javascript">
	$(function(){
        $(document).off('change', '#room_image').on('change', '#room_image', function(evt){ 

        //$('#room_image').on('change', function(evt){ 
            var tgt = evt.target || window.event.srcElement,files = tgt.files; 
            if (FileReader && files && files.length) {
                var fr = new FileReader();
                fr.onload = function () {
                    document.getElementById('prev_img').src = fr.result;
                    $('.upload_btn').html('Change Photo');
                }
                fr.readAsDataURL(files[0]);
            }  
        });

        
        $(document).off('click','.update-btn').on('click','.update-btn', function(e){
            e.preventDefault();
            var $form = $('#edit-users-form');
            var $url = $form.attr('action');
            $.ajax({
              type: 'POST',
              url: $url,
              data: new FormData($("#edit-users-form")[0]),
              async: false,
              processData: false,
              contentType: false,
              success: function(result){
                if(result.success){
                  swal({
                      title: result.msg,
                      icon: "success"
                    });
                }else{
                  swal({
                      title: result.msg,
                      icon: "error"
                    });
                }
                $("#roomsDatatable").DataTable().ajax.url( '/manage-rooms/getRoomsDatatable' ).load();
                $('.modal').modal('hide');
              },
              error: function(xhr,status,error){
                var response_object = JSON.parse(xhr.responseText); 
                associate_errors(response_object.errors, $form);
              }
            });
        });  
     });  
</script>				
<!-- $("#edit-users-form").serialize(), -->
			
