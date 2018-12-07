@extends('admin.app')

@section('content')
<div class="container">
    <h1 class="text-center">Manage Amenities</h1>
<hr>        
</div>

<div class="container">
    <div class="row mt-2">
        <div class="col-md-2 m-auto">
            <a href="#" class="btn btn-info btn-block add-data-btn" data-toggle="modal" data-target="#addAmenitiesModal">
                <i class="fa fa-plus"></i> Add Amenities</a>
        </div>
    </div>

<!-- Datatable -->
    <div class="col-md-12 mt-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped  mt-3" id="amenityDatatable">
                <thead class="thead-light">
                    <th>Id</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Rate</th>
                    <th>Actions</th>
                </thead>
            </table>
        </div>
    </div>
    <hr>
</div>

<div class="modal fade" id="addAmenitiesModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Add Amenities</h5>
                <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editAmenitiesModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Edit Amenity</h5>
                <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="availAmenitiesModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Avail Amenity</h5>
                <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(function() {
    $('#amenityDatatable').DataTable({
        bProcessing: true,
        bServerSide: false,
        sServerMethod: "GET",
        ajax: {
            "url": '/manage-amenities/getAmenitiesDatatable',
            "type": "GET"
        },
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'amen_name',
                name: 'amen_name'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'rate', render: $.fn.dataTable.render.number( ',', '.', 2, 'P' ),
                name: 'rate'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    })
});

//Call the add button modal
$(document).off('click', '.add-data-btn').on('click', '.add-data-btn', function(e) {
    e.preventDefault();
    var that = this;
    $("#addAmenitiesModal").modal();
    $("#addAmenitiesModal .modal-body").load('/manage-amenities/create');
});

//Call the edit button modal
$(document).off('click', '.edit-data-btn').on('click', '.edit-data-btn', function(e) {
    e.preventDefault();
    var that = this;
    $("#editAmenitiesModal").modal();
    $("#editAmenitiesModal .modal-body").load('/manage-amenities/' + that.dataset.id + '/edit', function(res) {});
});

//Call the avail button modal
$(document).off('click', '.avail-data-btn').on('click', '.avail-data-btn', function(e) {
    e.preventDefault();
    var that = this;
    $("#availAmenitiesModal").modal();
    $("#availAmenitiesModal .modal-body").load('/manage-amenities/' + that.dataset.id + '/avail', function(res) {});
});

//Call the delete button modal
$(document).off('click', '.delete-data-btn').on('click', '.delete-data-btn', function(e) {
    e.preventDefault();
    var that = this;
    bootbox.confirm({
        title: "Confirm Delete Data?",
        className: "del-bootbox",
        message: "Are you sure you want to delete record?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function(result) {
            if (result) {
                var token = '{{csrf_token()}}';
                $.ajax({
                    url: '/manage-amenities/' + that.dataset.id,
                    type: 'post',
                    data: {
                        _method: 'delete',
                        _token: token
                    },
                    success: function(result) {
                        $("#amenityDatatable").DataTable().ajax.url('/manage-amenities/getAmenitiesDatatable').load();
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
                    }
                });
            }
        }
    });
});
</script>
@endsection