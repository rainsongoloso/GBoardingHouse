<form action="/admin/{{$occupant->id}}/availed" method="POST" id="avail-users-form">

	{{csrf_field()}}
	
    <div class="form-group">
        <label for="amenity">Amenities:</label>
        <select class="custom-select" id="amenity" name="amenity" required>
            @if(count($amenities) > 0)
            <option value="0" selected>Choose amenity...</option>
            @foreach($amenities as $amenity)
            <option value="{{$amenity->id}}">{{$amenity->amen_name}}</option>
            @endforeach 
            @endif
        </select>
        <span class="help-text text-danger"></span>
    </div>

   <!--  @if(count($amenities) > 0)
      @foreach($amenities as $amenity)
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="{{$amenity->id}}" value="{{$amenity->id}}" name= "amenities[]">
          <label class="form-check-label" for="{{$amenity->id}}">{{$amenity->amen_name}}</label>
        </div>
      @endforeach
    @endif -->
<!-- 
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="aementi" name= "amenities_avail" value="1">
        <label class="form-check-label" for="aementi"></label>
      </div> -->



   <!-- @if(count($amenities) > 0)
    @foreach($amenities as $amenity)
      <div class="form-check">
        <label class="form-check-label">
          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
            {{$amenity->amen_name}}
        </label>
      </div> 
    @endforeach
  @endif -->

    <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary avail-btn">Update</button>
    </div>
</form>

<script type="text/javascript">
$(function(){
        $(document).off('click','.avail-btn').on('click','.avail-btn', function(e){
            e.preventDefault();
            var $form = $('#avail-users-form'); 
            var $url = $form.attr('action');
            $.ajax({
              type: 'POST',
              url: $url,
              data: $("#avail-users-form").serialize(), 
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
                $("#occupantsDatatable").DataTable().ajax.url( '/admin/occupantsDatatable' ).load();
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