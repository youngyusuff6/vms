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
              
        <table class="table" id="visitor">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Purpose</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($LOG as $visitor)
                <tr>
                    <td>{{$COUNTER++}}</td>
                    <td>{{ $visitor->name }}</td>
                    <td>{{ $visitor->email }}</td>
                    <td>{{ $visitor->phone_number }}</td>
                    <td>{{ $visitor->purpose }}</td>
                    <td>{{ $visitor->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @endif

        @if ($DATA_AVAILABILITY < 1)
        <div class="d-flex justify-content-center mt-4 mb-3 h2"> No Data Available </div>
        @endif
    </div>
</div>

@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
<link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">
@endsection

@section('scripts')
<script src="{{url("DASHBOARD_ASSETS/plugins/jquery/jquery.min.js")}}"></script>
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

<script>
    var $j = jQuery.noConflict();

    $j(document).ready(function() {
        $j('#visitor').DataTable({
            columnDefs: [
                {
                    targets: [2], // Specify the column indexes where you want to remove sorting arrows
                    orderable: false, // Disable sorting for the specified columns
                    searchable: false // Disable searching for the specified columns
                }
            ],
            pageLength: 25,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
    });
</script>
@endsection
