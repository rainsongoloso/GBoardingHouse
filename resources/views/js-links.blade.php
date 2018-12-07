<!-- main for datatables -->
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery-ui.min.js')}}"></script>
<!-- datepicker -->
<script type="text/javascript" src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<!-- Datatable buttons -->
<script type="text/javascript" src="{{asset('js/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/buttons.flash.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('js/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/buttons.print.min.js')}}"></script>
<!-- Others -->
<script type="text/javascript" src="{{asset('js/parsley.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('js/sweetalert.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootbox.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<!-- Chart -->
<script type="text/javascript" src="{{asset('js/Chart.bundle.min.js')}}"></script>
<!-- select2 -->
<script type="text/javascript" src="{{asset('js/select2.full.min.js')}}"></script>


<script type="text/javascript">
	function associate_errors(errors, $form)
	{	 
	    //remove existing error classes and error messages from form groups
	    $form.find('.form-group').removeClass('has-danger').find('.help-text').text('');
	   
	    $.each(errors, function(value, index){

	        //find each form group, which is given a unique id based on the form field's name  add the error class and set the error text
	        $('#'+value).parent().addClass('has-danger').find('.help-text').text(index.join(' '));
	        console.log(index.join(' '));
	        $('#'+value).addClass('form-control-danger');
	    });
	}
</script>