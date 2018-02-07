@extends('admin.app')

@section('content')
<div class="container">
<h1 class="text-center mb-4">Occupancy Report</h1>
<form id="generate-formc" action="/reports/cReportsDatatable" method="POST">
      <div class="row ">
        <div class="col-md-3">
            <div class="input-group mb-3">
               <div class="input-group-prepend">
                  <label class="input-group-text" for="filter">Filter to:
               </div>
               <select  class="custom-select" id="filter" name="filter">
                  <option selected>Choose...</option>
                  <option value="0">Annually</option>
                  <option value="1">Monthly</option>
                  <option value="2">Year&Month</option>
               </select>
            </div>
         </div>

         <div class="col-md-3" id="hideY">
            <div class="input-group mb-3" >
               <div class="input-group-prepend">
                  <label class="input-group-text" for="year">Year</label>
               </div>
               <select class="custom-select" id="year" name="year">
                  <option selected>Choose...</option>
                  <option value="2018">2018</option>
                  <option value="2017">2017</option>
                  <option value="2016">2016</option>
                  <option value="2015">2015</option>
                  <option value="2014">2014</option>
                  <option value="2013">2013</option>
                  <option value="2012">2012</option>
                  <option value="2011">2011</option>
                  <option value="2010">2010</option>
               </select>
            </div>
         </div>
        
         <div class="col-md-3" id="hideM">
            <div class="input-group mb-3">
               <div class="input-group-prepend">
                  <label class="input-group-text" for="month">Month</label>
               </div>
               <div id="mon"></div>
               <select class="custom-select" id="month" name="month">
                  <option selected>Choose...</option>
                  <option value="1">January</option>
                  <option value="2">February</option>
                  <option value="3">March</option>
                  <option value="4">April</option>
                  <option value="5">May</option>
                  <option value="6">June</option>
                  <option value="7">July</option>
                  <option value="8">August</option>
                  <option value="9">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
               </select>
            </div>
         </div>
         <div class="col-md-3">
            <button id="hideB" type="submit" class="btn btn-info">Generate</button>
         </div>
      </div>
   </form>



<div class="row" id="hideT">
 <div class="col-md-12">         
    <div class="table"> 
        <table class="table table-bordered table-striped table-hover" id="cReportsTable">
          <thead class="thead-dark">
            <tr>
              <th>Occupant Id</th>
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Room No.</th>
              <th>Amenity Availed</th>
            </tr>
          </thead>
        </table>
    </div>
  </div>
</div>
<!-- <div class="row">
  <div class="col-md-5 ">
    <h3>Total Occupants: {{$occupant}}<h3>
  </div>
</div> -->
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function()
{
  var x = document.getElementById("hideY");
              x.style.display = "none";

  var y = document.getElementById("hideM");
    y.style.display = "none";

  var z = document.getElementById("hideB");
    z.style.display = "none";

  var z = document.getElementById("hideB");
    z.style.display = "none";

    $("#filter").change(function()
    {
        var id= $(this).val();

        if(id == 0)
        { 
          var x = document.getElementById("hideM");
              x.style.display = "none";

          var y = document.getElementById("hideY");
              y.style.display = "block";

          var z = document.getElementById("hideB");
              z.style.display = "block";      

        }
        else if(id == 1)
        {
          var x = document.getElementById("hideY");
              x.style.display = "none";

          var y = document.getElementById("hideM");
            y.style.display = "block";

          var z = document.getElementById("hideB");
            z.style.display = "block";  
          
        } 
        else if(id == 2)
        {
          var x = document.getElementById("hideY");
              x.style.display = "block";

          var y = document.getElementById("hideM");
            y.style.display = "block";

          var z = document.getElementById("hideB");
            z.style.display = "block";  
        }
        else
        {
          var x = document.getElementById("hideY");
              x.style.display = "none";

          var y = document.getElementById("hideM");
            y.style.display = "none";

          var z = document.getElementById("hideB");
            z.style.display = "none";

            $(".hideM").val(""); 

            $(".hideY").val(""); 
        }
    });
});

// $(function() {
    var oTable = $('#cReportsTable').DataTable({
            bProcessing: true,
            bServerSide: true,
            // sServerMethod: "GET",
            ajax:{
                "url":'/reports/cReportsDatatable',
                // "type": "GET"
                data: function (d) {
                d.year = $('select[name=year]').val();
                d.month = $('select[name=month]').val();
                d.filter = $('select[name=filter]').val();
              }
            },
            columns: [
                {data: 'id',      name: 'id'},    
                {data: 'firstname',    name: 'firstname'},
                {data: 'lastname',    name: 'lastname'},
                {data: 'room_no',    name: 'room_no'},
                {data: 'amen_name',    name: 'amen_name'},  
            ],
            dom: 'Bfrtip',

            buttons: [
              { extend: 'copyHtml5', 
              footer: true,  
              },

              { extend: 'excelHtml5', 
              footer: true, 
              title: 'Goloso Boarding House Reports',
              },

              { extend: 'csvHtml5',
              title: 'Goloso Boarding House Reports', 
              footer: true },

              { extend: 'pdfHtml5', 
              footer: true,
              title: 'Goloso Boarding House Reports',
              
              },

            ],
        });
// });

$('#generate-formc').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });
</script>
@endsection