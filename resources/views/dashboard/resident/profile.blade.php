@extends('layouts.resident')
@section('title')Profile @endsection

@section('content')
@php
$RESIDENT_OBJECT = ACCOUNT_IMAGE_RESOLVER("resident");
@endphp
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
            
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ url($RESIDENT_OBJECT['DP_URL']) }}"
                        alt="User profile picture">
                        
                        <h3 class="profile-username text-center">{{ $RESIDENT_OBJECT['NAME'] }}</h3>
                        
                        <p class="text-muted text-center">@isset($RESIDENT->occupation) {{ $RESIDENT->occupation}} @endisset</p>
                </div>
                
                <hr>
                <form>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="tel" class="form-control" id="phone_number" value="{{$RESIDENT_DATA->phone_number}}" name="phone_number" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Office Number</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{$RESIDENT_DATA->office_number}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{$RESIDENT_DATA->address}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" value="{{ optional($RESIDENT_DATA->date_of_birth)->format('Y-m-d') }}" readonly name="date_of_birth">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emergency_contact_name">Emergency Contact Name</label>
                                <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" value="{{$RESIDENT_DATA->emergency_contact_name}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="emergency_contact_number">Emergency Contact Number</label>
                                <input type="tel" class="form-control" id="emergency_contact_number" name="emergency_contact_number" value="{{$RESIDENT_DATA->emergency_contact_number}}" readonly>
                            </div>
                        </div>
                    
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="id_number">ID Number</label>
                                <input type="text" class="form-control" id="id_number" name="id_number" value="{{$RESIDENT_DATA->id_number}}" readonly>
                            </div>
                        </div>
                    
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="vehicle_registration">Vehicle Plate Number</label>
                                <input type="text" class="form-control" id="vehicle_plate_number" name="vehicle_plate_number" value="{{$RESIDENT_DATA->vehicle_plate_number}}" readonly>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="text-right">
                    <a href="{{route('resident.profile.edit')}}" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

@endsection
