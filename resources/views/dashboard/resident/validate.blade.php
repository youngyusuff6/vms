@extends('layouts.resident')
@section('title')Validate Visitors @endsection
@section('page-title') Validate Visitors @endsection

@section('content')

<div class="container">
    <div class="row">
        @php
            $DATA_AVAILABILITY = $visitors_count;
            $COUNTER = 1;
        @endphp
        @if ($DATA_AVAILABILITY > 0)
              
        <table id="visitor-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($visitors as $visitor)
                <tr>
                    <td>{{$COUNTER++}}</td>
                    <td>{{$visitor->name}}</td>
                    <td>
                        <a href="" class="btn btn-success light" data-toggle="modal" data-target="#modal-info_{{$visitor->id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-main-icon" width="24px" height="24px" viewBox="0 0 32 32" x="0px" y="0px"><g data-name="Layer 21"><path d="M29,14.47A15,15,0,0,0,3,14.47a3.07,3.07,0,0,0,0,3.06,15,15,0,0,0,26,0A3.07,3.07,0,0,0,29,14.47ZM16,21a5,5,0,1,1,5-5A5,5,0,0,1,16,21Z" fill="#000000" fill-rule="nonzero"></path><circle cx="16" cy="16" r="3" fill="#000000" fill-rule="nonzero"></circle></g></svg>
                        </a>
                    </td>
                    <td colspan="2">
                        <div class="d-flex">
                            <form action="{{ route('resident.visitor.accept', ['id' => tokenize($visitor->id)]) }}" class="mx-2" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Accept</button>
                            </form>
                            <form action="{{ route('resident.visitor.reject', ['id' => tokenize($visitor->id)]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger ">Reject</button>
                            </form>    
                        </div>
                    </td>
                </tr>
                {{-- MODAL --}}

                     <!-- /.modal -->

      <div class="modal fade" id="modal-info_{{$visitor->id}}">
        <div class="modal-dialog">
          <div class="modal-content bg-secondary">
            <div class="modal-header">
              <h4 class="modal-title">Visitor Details</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body"> 
                    <p><b>Phone:</b> {{$visitor->phone_number}}</p>
                    <br>
                    <p><b>Purpose of Visit:</b> {{$visitor->purpose}}</p>
                    <br>
                    <p><b>Email:</b> {{$visitor->email}}</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
              <div class="d-flex">
                <form action="{{ route('resident.visitor.accept', ['id' => tokenize($visitor->id)]) }}" class="mx-2" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Accept</button>
                </form>
                <form action="{{ route('resident.visitor.reject', ['id' => tokenize($visitor->id)]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger ">Reject</button>
                </form>    
            </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

                {{-- MODAL --}}

                @endforeach
            </tbody>
        </table>
        @else
        <div class="d-flex justify-content-center mt-4 mb-3 h2"> No pending visitor!</div>
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
