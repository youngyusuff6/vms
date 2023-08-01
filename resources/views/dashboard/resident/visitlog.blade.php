@extends('layouts.resident')
@section('title')Visitors Log @endsection
@section('page-title') Visitors Log @endsection

@section('content')
<div class="container">
    <div class="row">
        @php
            $DATA_AVAILABILITY = $LOG_COUNT;
            $COUNTER = 1;
        @endphp
        @if ($DATA_AVAILABILITY > 0)
              
        <table id="visitor-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th class="wider-column">Purpose</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($LOG as $visitor)
                <tr>
                    <td>{{ $COUNTER++ }}</td>
                    <td>{{ $visitor->name }}</td>
                    <td>{{ $visitor->email }}</td>
                    <td>{{ $visitor->phone_number }}</td>
                    <td>{{ $visitor->purpose }}</td>
                    <td>
                      @if($visitor->status === 'Pending')
                          <span class="badge badge-warning">{{ $visitor->status }}</span>
                      @elseif($visitor->status === 'In Progress')
                          <span class="badge badge-info">{{ $visitor->status }}</span>
                      @elseif($visitor->status === 'Completed')
                          <span class="badge badge-success">{{ $visitor->status }}</span>
                      @elseif($visitor->status === 'Rejected')
                          <span class="badge badge-danger">{{ $visitor->status }}</span>
                      @else
                          <span class="badge badge-secondary">{{ $visitor->status }}</span>
                      @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    
        @endif
    </div>
</div>
@endsection

@section('styles')
 <!-- Include DataTables CSS -->
 {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css"> --}}
 <link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/DASHBOARD_ASSETS/plugins/plugins/datatables/jquery.dataTables.min.css")}}">
 <link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
<link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">

<style>
  .wider-column {
  width: 200px; /* Adjust the width as needed */
}
#visitor-table_wrapper {
  width: 100%;
}

#visitor-table {
  width: 100%;
}

</style>
@endsection

@section('scripts')
<!-- jQuery -->
<script src="{{url("DASHBOARD_ASSETS/plugins/jquery/jquery.min.js")}}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{url("DASHBOARD_ASSETS/plugins/jquery-ui/jquery-ui.min.js")}}"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Include DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
{{-- <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/colvis/1.2.0/js/dataTables.colVis.min.js"></script> --}}

<script src="{{url("DASHBOARD_ASSETS/plugins/plugins/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETS/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETS/plugins/datatables-responsive/js/dataTables.responsive.min.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETS/plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETS/plugins/datatables-buttons/js/dataTables.buttons.min.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETS/plugins/datatables-buttons/js/buttons.bootstrap4.min.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETS/plugins/jszip/jszip.min.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETS/plugins/pdfmake/pdfmake.min.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETS/plugins/pdfmake/vfs_fonts.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETS/plugins/datatables-buttons/js/buttons.html5.min.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETS/plugins/datatables-buttons/js/buttons.print.min.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETS/plugins/datatables-buttons/js/buttons.colVis.min.js")}}"></script>


<!-- DataTables initialization -->
<script>
  var $j = jQuery.noConflict(true);

  $j(function() {
    var table = $j('#visitor-table').DataTable({
      responsive: true,
      dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-6'B><'col-sm-6'p>>",
      pageLength: 10,
      buttons: [
        'copy',
        'pdf',
        'csv',
        'print',
        'colvis'
      ],
      colVis: {
        buttonText: 'Column Visibility'
      },
     
    });

    table.buttons().container().appendTo('#table-buttons');
  });
</script>
@endsection
