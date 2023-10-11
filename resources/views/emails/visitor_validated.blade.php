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
                <p>Your navigation details:</p>
                <iframe src="https://use.mazemap.com/#v=1&config=ntnu&zlevel=1&center=10.404776,63.421030&zoom=18&sharepoitype=bld&sharepoi=57&campusid=1" width="500" height="400"></iframe>
                <p>Thank you.</p>
            </div>
        </div>
    </div>
</body>
@endsection