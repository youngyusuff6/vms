@extends('layouts.security')
@section('title') Security Dashboard @endsection

@section('content')
@php
$SECURITY_OBJECT = ACCOUNT_IMAGE_RESOLVER("security");
@endphp

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">

            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{ url($SECURITY_OBJECT['DP_URL']) }}" alt="User profile picture">    
                <h3 class="profile-username text-center">{{ $SECURITY_OBJECT['NAME'] }}</h3>
            </div>

            <hr>
            <form action="{{ route('security.profile.update') }}" method="POST" >
                @csrf
                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="tel" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number', $SECURITY_DATA->contact_number) }}">
                    @error('contact_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="emergency_contact_number">Emergency Contact Number</label>
                    <input type="tel" class="form-control @error('emergency_contact_number') is-invalid @enderror" id="emergency_contact_number" name="emergency_contact_number" value="{{ old('emergency_contact_number', $SECURITY_DATA->emergency_contact_number) }}">
                    @error('emergency_contact_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="job_title">Job Title</label>
                    <input type="text" class="form-control @error('date_of_birth') is-invalid @enderror" id="job_title" value="{{ old('job_title', optional($SECURITY_DATA->job_title)->format('Y-m-d')) }}" name="job_title">
                    @error('job_title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <!-- Rest of the form fields with the same structure -->

                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
