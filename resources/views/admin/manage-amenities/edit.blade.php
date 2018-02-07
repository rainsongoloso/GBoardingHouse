<form action="/manage-amenities/{{ $amen->id }}" method="PATCH" id="edit-amenity-form">

    {{csrf_field()}}

    <div class="form-group">

        <label for="amen_name">Name</label>
        <input id="amen_name" type="text" name="amen_name" class="form-control" value="{{ $amen->amen_name }}" required>
        <span class="help-text text-danger"></span>
        
        <label for="rate">Rate</label>
        <input id="rate" type="text" name="rate" class="form-control" value="{{ $amen->rate }}" required>
        <span class="help-text text-danger"></span>

        <label for="description">Description</label>
        <textarea id="description" type="text" name="description" class="form-control" required>
            {{ $amen->description }}
        </textarea>
        <span class="help-text text-danger"></span>

    </div>

    <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button class="btn btn-success update-btn">Update</button>
    </div>

</form>

<script type="text/javascript">
	$(function() {
    $(document).off('click', '.update-btn').on('click', '.update-btn', function(e) {
        e.preventDefault();
        var $form = $('#edit-amenity-form');
        var $url = $form.attr('action');
        $.ajax({
            type: 'PATCH',
            url: $url,
            data: $("#edit-amenity-form").serialize(),
            success: function(result) {
                if (result.success) {
                    swal({
                        title: result.msg,
                        icon: "success"
                    });
                } else {
                    swal({
                        title: result.msg,
                        icon: "error"
                    });
                }
                $("#amenityDatatable").DataTable().ajax.url('/manage-amenities/getAmenitiesDatatable').load();
                $('.modal').modal('hide');
            },
            error: function(xhr, status, error) {
                var response_object = JSON.parse(xhr.responseText);
                associate_errors(response_object.errors, $form);
            }
        });
    });
});
</script>

