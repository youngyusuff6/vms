@extends('layouts.email')

@section('content')
    <body>
        <div class="email-whole">
            <div class="email-content">
                <div class="email-header">
                    <h1>Visit Validated</h1>
                </div>

                <div class="email-body">
                    <p>Dear {{ $visitor->name }},</p>
                    <p>Your visit with unique ID {{ $visitor->unique_id }} has been validated. You can now proceed to complete your visit with the resident.</p>
                    <p>Your navigation details: 
                        {{-- NAVIGATION --}}

                    </p>
                    <p>Thank you.</p>
                </div>
            </div>
        </div>
    </body>
@endsection
