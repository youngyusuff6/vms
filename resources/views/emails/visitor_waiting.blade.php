@extends('layouts.email')

@section('content')
    <body>
        <div class="email-whole">
            <div class="email-content">
                <div class="email-header">
                    <h1>Visit Scheduled</h1>
                </div>

                <div class="email-body">
                    <p>Dear {{ $visitor->name }},</p>
                    <p>Your visit with unique ID <span class="fw-bold">{{ $visitor->unique_id }}</span> has been scheduled. Please be informed that you need to wait for residents approval before proceeding with your visit.</p>
                    <p>
                        Here are the details of your scheduled visit:
                      <p>- Purpose: {{ $visitor->purpose }}</p>
                      <p>- Date: {{ $visitor->visit_date }}</p> 
                      <?php
                       $visitTimeTimestamp = strtotime($visitor->visit_time );
                        // Format the time as "H:i A" to include AM or PM
                        $formattedVisitTime = date('g:i A', $visitTimeTimestamp);
                      ?>
                      <p>- Time: {{  $formattedVisitTime}}</p>  
                    </p>
                    <p>Thank you.</p>
                </div>
            </div>
        </div>
    </body>
@endsection
