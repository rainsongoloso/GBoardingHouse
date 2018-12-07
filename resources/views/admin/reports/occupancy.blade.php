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
               <select  class="custom-select" id="filter" name="filter" onchange="myFunction()">
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
               <select class="custom-select" id="year" name="year" onchange="myFunction()">
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
               <select class="custom-select" id="month" name="month" onchange="myFunction()">
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
          <thead class="thead-light">
            <tr>
              <th>Occupant Id</th>
              <th>Name</th>
              <th>Room no.</th>
              <th>Room type</th>
              <th>Amenities</th>
            </tr>
          </thead>
        </table>
    </div>
  </div>
</div>
<!-- <div class="row">
  <div class="col-md-5 ">
    <h3>Total Occupants<h3>
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
                {data: 'name',    name: 'name'},
                {data: 'roomNo',    name: 'roomNo'},
                {data: 'roomType',    name: 'roomType'},
                {data: 'amenities',    name: 'amenities'},  
            ],
            dom: 'Bfrtip',

            buttons: [
              { extend: 'excelHtml5', 
              footer: true,
              messageTop: function myFunction() {
                  var getFilter = document.getElementById('filter'),
                      getFilterTo = getFilter.value;
                  var getYear = document.getElementById('year'),
                      getYearTo = getYear.value;  
                  var getMonth = document.getElementById('month'),
                      getMonthTo = getMonth.value; 
                  var months = ["January","February","March","April","May","June","July","August","September","November","December"];

                  if(getFilterTo == 0){
                    return 'Occupancy Report for the Year '+getYearTo+'';
                  }
                  else if(getFilterTo == 1){
                    return 'Occupancy Report for the Month of '+months[getMonthTo-1]+'';
                  }
                  else{
                    return 'Occupancy Report for '+months[getMonthTo-1]+'/'+getYearTo+'';
                  }
              }, 
              title: 'Goloso Boarding House Reports',
              },

              { extend: 'csvHtml5',
              title: 'Goloso Boarding House Reports',
              messageTop: function myFunction() {
                  var getFilter = document.getElementById('filter'),
                      getFilterTo = getFilter.value;
                  var getYear = document.getElementById('year'),
                      getYearTo = getYear.value;  
                  var getMonth = document.getElementById('month'),
                      getMonthTo = getMonth.value; 
                  var months = ["January","February","March","April","May","June","July","August","September","November","December"];

                  if(getFilterTo == 0){
                    return 'Occupancy Report for the Year '+getYearTo+'';
                  }
                  else if(getFilterTo == 1){
                    return 'Occupancy Report for the Month of '+months[getMonthTo-1]+'';
                  }
                  else{
                    return 'Occupancy Report for '+months[getMonthTo-1]+'/'+getYearTo+'';
                  }
              }, 
              footer: true 
              },

              { extend: 'pdfHtml5',
              messageTop: function myFunction() {
                  var getFilter = document.getElementById('filter'),
                      getFilterTo = getFilter.value;
                  var getYear = document.getElementById('year'),
                      getYearTo = getYear.value;  
                  var getMonth = document.getElementById('month'),
                      getMonthTo = getMonth.value; 
                  var months = ["January","February","March","April","May","June","July","August","September","November","December"];

                  if(getFilterTo == 0){
                    return 'Occupancy Report for the Year '+getYearTo+'';
                  }
                  else if(getFilterTo == 1){
                    return 'Occupancy Report for the Month of '+months[getMonthTo-1]+'';
                  }
                  else{
                    return 'Occupancy Report for '+months[getMonthTo-1]+'/'+getYearTo+'';
                  }
              }, 
              customize: function ( doc ) 
              {
                doc.content.splice( 1, 0, {
                    margin: [ 0, 0, 0, 12 ],
                    alignment: 'center',
                    image: 'data: data:image/png;base64,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'} );
              },
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