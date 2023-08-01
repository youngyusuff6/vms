@extends('layouts.security')
@section('title')Profile @endsection

@section('content')
@php
$SECURITY_OBJECT = ACCOUNT_IMAGE_RESOLVER("security");
@endphp
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
            
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ url($SECURITY_OBJECT['DP_URL']) }}"
                        alt="User profile picture">    
                        <h3 class="profile-username text-center">{{ $SECURITY_OBJECT['NAME'] }}</h3>
                    </div>
                <hr>
                <form>

                    <div class="form-group">
                        <label for="badge_number">Badge Number</label>
                        <input type="text" class="form-control" id="badge_number" value="{{$SECURITY_DATA->badge_number}}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="tel" class="form-control" id="contact_number" value="{{$SECURITY_DATA->contact_number}}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="emergency_contact_number">Emergency Contact Number</label>
                        <input type="tel" class="form-control" id="emergency_contact_number" value="{{$SECURITY_DATA->emergency_contact_number}}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="job_title">Job Title</label>
                        <input type="text" class="form-control" id="job_title" value="{{ $SECURITY_DATA->job_title }}" readonly>
                    </div>

                </form>
                <div class="text-right">
                    <a href="{{route('security.profile.edit')}}" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

@endsection
