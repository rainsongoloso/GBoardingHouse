@extends('admin.app')

@section('content')
<div class="container">
   <h1 class="text-center mb-4">Monthly Income Report</h1>
   <form id="generate-form" action="/reports/mReportsDatatable" method="POST">
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
   <br>
   <div class="table">
      <table class="table table-striped table-hover" id="mReportsTable">
         <thead class="thead-dark">
            <tr>
               <th>Firstname</th>
               <th>Lastname</th>
               <!-- <th>Room</th>
               <th>Amenities</th> -->
               <th>Total Credit</th>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th colspan="2" style="text-align:right">Total Income:</th>
               <th></th>
            </tr>
         </tfoot>
      </table>
   </div>
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


// $(document).ready(function() {
      var oTable =  $('#mReportsTable').DataTable({
            bProcessing: true,
            bServerSide: true,
            // sServerMethod: "GET",
            ajax:{
                "url":'/reports/mReportsDatatable',
                // "type": "GET",
                 data: function (d) {
                d.year = $('select[name=year]').val();
                d.month = $('select[name=month]').val();
                d.filter = $('select[name=filter]').val();
              }
            },

            columns: [
                {data: 'firstname',       name: 'firstname'},
                {data: 'lastname',        name: 'lastname'},
                // {data: 'name1',      name: 'name1'},
                // {data: 'name2',            name: 'name2'},   
                {data: 'total_credit', render: $.fn.dataTable.render.number( ',', '.', 2, 'P' ),    name: 'total_credit'},
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

            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'P' ).display;
            $( api.column( 2 ).footer() ).html(
                numFormat(pageTotal) +' ('+ numFormat(total) +' total)'
            );
        }

      });     
// });

$('#generate-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });
</script>
@endsection