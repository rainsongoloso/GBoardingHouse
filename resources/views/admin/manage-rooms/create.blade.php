<form enctype="multipart/form-data" action="/manage-rooms" method="POST" id="add-rooms-form" >

    {{csrf_field()}}

    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="room_number">Room No.</label>
            <input type="text" id="room_number" name="room_no" class="form-control" required>
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-3">
            <label for="room_status">Status</label>
            <select class="custom-select" id="room_status" name="status" required>
                <option value="Available">Available</option>
                <option value="Unavailable">Unavailable</option>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label for="room_type">Type</label>
            <select class="custom-select" id="room_type" name="type" required>
                <option value="Bed Spacer">Bed Spacer</option>
                <option value="Private">Private</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="room_rate">Rate</label>
            <input  type="text" id="room_rate" min="0" name="rate" class="form-control" required>
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-6">
            <label for="room_max_capacity">Max Capacity</label>
            <input type="number" id="room_max_capacity" min="0" name="max_capacity" class="form-control" required>
            <span class="help-text text-danger"></span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="room_description">Description</label>
            <textarea type="text" id="room_description"  name="description" class="form-control" placeholder="Description" required>
            </textarea>
            <span class="help-text text-danger"></span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="image">Room Image</label>
            <input type="file" id="image" name="room_image" class="form-control-file">
            <span class="help-text text-danger"></span>
        </div>
    </div>
    
    <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-warning add-btn">Submit</button>
    </div>
    
</form>

<script type="text/javascript">
	$(function(){
        $(document).off('click','.add-btn').on('click','.add-btn', function(e){
            e.preventDefault();
            var $form = $('#add-rooms-form');
            var $url = $form.attr('action');
            $.ajax({
              type: 'POST',
              url: $url,
              data: new FormData($("#add-rooms-form")[0]),
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

<!-- $("#add-rooms-form").serialize() -->
<!-- id="add-rooms-form" -->
<!-- enctype="multipart/form-data" -->