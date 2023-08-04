@extends('layouts.email')

@section('content')
    <body>
        <div class="email-whole">
            <div class="email-content">
                <div class="email-header">
                    <h1>Visit Scheduled</h1>
                </div>

                <div class="email-body">
                    <p>Dear {{ $name }},</p>
                    <p>Your visit has been scheduled with resident {{ $residentName }}.</p>
                    <p>Your visitor unique ID is <span class="fw-bold">{{ $visitorId }}</span>.</p>
                    <p>Date: {{ $visitDate }}</p>
                    <p>Time: {{ $visitTime }}</p>
                    <p>Kindly show your unique ID to the security for validation.</p>
                    <p>Thank you.</p>
                </div>
            </div>
        </div>
    </body>
@endsection
