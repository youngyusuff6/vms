@extends('layouts.security')
@section('title', 'Visitor Details')
@section('page-title', 'Visitor Details')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <h2 class="fw-bold text-success text-center">VISITOR FOUND!</h2> 
                <p><strong>Name:</strong> {{ $visitor->name }}</p>
                <p><strong>Email:</strong> {{ $visitor->email }}</p>
                <p><strong>Phone:</strong> {{ $visitor->phone_number }}</p>
                <p><strong>Purpose:</strong> {{ $visitor->purpose }}</p>
                <p><strong>Visit Date:</strong> {{ $visitor->visit_date }}</p>
                <p><strong>Visit Time:</strong> {{ $visitor->visit_time }}</p>
                <!-- Add other details here -->
                <div id="validateButtonContainer">
                    @if ($visitor->status !== 'Success')
                    <form id="validateForm" action="{{ route('security.visitor.validated') }}" method="POST">
                        @csrf
                        <input type="hidden" name="visitor_id" value="{{ $visitor->id }}">
                        <button type="submit" id="validateButton" class="btn btn-success">Validate</button>
                    </form>
                    @else
                        <p class="btn btn-success">Validated!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add the click event handler for the "Validate" button
    $(document).ready(function () {
        $('#validateForm').on('submit', function () {
            // Disable the "Validate" button to prevent multiple submissions
            $('#validateButton').prop('disabled', true);
            // Show the loading spinner
            $('#validateButtonContainer').append('<div class="spinner-border spinner-border-sm" role="status"></div>');
        });
    });
</script>
@endsection
