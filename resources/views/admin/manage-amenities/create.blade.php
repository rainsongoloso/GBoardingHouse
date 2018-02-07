<form action="/manage-amenities" method="POST" id="add-amenity-form">

    {{csrf_field()}}

    <div class="form-group">

        <label for="amen_name">Name</label>
        <input id="amen_name" type="text" name="amen_name" class="form-control" required>
        <span class="help-text text-danger"></span>

        <label for="rate">Rate</label>
        <input id="rate" type="numeric" name="rate" class="form-control" required>
        <span class="help-text text-danger"></span>

        <label for="description">Description</label>
        <textarea id="description" type="text" name="description" class="form-control" placeholder="Description" required>
        </textarea>
        <span class="help-text text-danger"></span>

    </div>

    <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button class="btn btn-info add-btn">Submit</button>
    </div>

</form>

<script type="text/javascript">
	$(function() {
    $(document).off('click', '.add-btn').on('click', '.add-btn', function(e) {
        e.preventDefault();
        var $form = $('#add-amenity-form');
        var $url = $form.attr('action');
        $.ajax({
            type: 'POST',
            url: $url,
            data: $("#add-amenity-form").serialize(),
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
