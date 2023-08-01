@extends('layouts.security')
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
                    <th colspan="2">Sign In & Sign Out</th>
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
                        @else
                            <span class="badge badge-secondary">{{ $visitor->status }}</span>
                        @endif
                    </td>
                    <td>
                        <?php
                        if ($visitor->sign_in_time) {
                            echo date('g:i A', strtotime($visitor->sign_in_time));
                        } else {
                            echo 'Not signed in';
                        }
                        ?>
                    <td>
                        @if ($visitor->sign_out_time)
                            {{ date('g:i A', strtotime($visitor->sign_out_time)) }}
                        @elseif ($visitor->sign_in_time)
                            <form action="{{ route('security.visitor.signout', ['id' => tokenize($visitor->id)]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Sign Out</button>
                            </form>
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
