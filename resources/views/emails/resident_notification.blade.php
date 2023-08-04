@extends('layouts.email')

@section('content')
    <body>
        <div class="email-whole">
            <div class="email-content">
                <div class="email-header">
                    <h1>Visitor Waiting for Validation</h1>
                </div>

                <div class="email-body">
                    <p>Dear {{$resident->name}},</p>
                    <p>A visitor with the following details has requested to visit you. Please review the information and either accept or reject the visit.</p>

                    <p>Visitor Details:</p>
                    <p>Name: {{ $visitor->name }}</p>
                    <p>Email: {{ $visitor->email }}</p>
                    <p>Phone: {{ $visitor->phone_number }}</p>
                    <p>Purpose: {{ $visitor->purpose }}</p>
                    <p>Date: {{ $visitor->visit_date }}</p>
                    <?php $visitTimeTimestamp = strtotime($visitor->visit_time );
                    // Format the time as "H:i A" to include AM or PM
                    $formattedVisitTime = date('g:i A', $visitTimeTimestamp);
                     ?>
                    <p>Time: {{  $formattedVisitTime}}</p>

                    <p>Visitor ID: <span class="fw-bold">{{ $visitor->unique_id }}</span></p>

                    <p>Please log in to the VMS dashboard to validate the visit.</p>

                    <p>Thank you for using our Visitor Management System.</p>
                </div>
            </div>
        </div>
    </body>
@endsection
