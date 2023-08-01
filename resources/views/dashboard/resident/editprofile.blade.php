@extends('layouts.resident')
@section('title')Edit Profile @endsection
@section('page-title') Edit Profile @endsection

@section('content')
@php
$RESIDENT_OBJECT = ACCOUNT_IMAGE_RESOLVER("resident");
@endphp

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">

            <div class="text-center">
                <label for="imageInput">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ url($RESIDENT_OBJECT['DP_URL']) }}"
                       alt="User profile picture">
                </label>
                <input id="imageInput" type="file" style="display: none;">
              </div>
              

            <hr>
            <form action="{{route('resident.profile.update')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name ?? old('name') }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <span class="text-danger">*</span>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" value="{{ $RESIDENT->phone_number ?? old('phone_number') }}">
                            @error('phone_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="office_number">Office Number</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="office_number" name="office_number" value="{{ $RESIDENT->office_number ?? old('office_number') }}">
                            @error('office_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $RESIDENT->address ?? old('address') }}">
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{  optional($RESIDENT->date_of_birth)->format('Y-m-d')  ?? old('date_of_birth') }}">
                            @error('date_of_birth')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="emergency_contact_name">Emergency Contact Name</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" value="{{ $RESIDENT->emergency_contact_name ?? old('emergency_contact_name') }}">
                            @error('emergency_contact_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="emergency_contact_number">Emergency Contact Number</label>
                            <span class="text-danger">*</span>
                            <input type="tel" class="form-control" id="emergency_contact_number" name="emergency_contact_number" value="{{ $RESIDENT->emergency_contact_number ?? old('emergency_contact_number') }}">
                            @error('emergency_contact_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="occupation">Occupation</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="occupation" name="occupation" value="{{ $RESIDENT->occupation ?? old('occupation') }}">
                            @error('occupation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_number">ID Number</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="id_number" name="id_number" value="{{ $RESIDENT->id_number ?? old('id_number') }}">
                            @error('id_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vehicle_plate_number">Vehicle Plate Number</label>
                            <input type="text" class="form-control" id="vehicle_plate_number" name="vehicle_plate_number" value="{{ $RESIDENT->vehicle_plate_number ?? old('vehicle_plate_number') }}">
                            @error('vehicle_plate_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Rest of the fields with the same structure -->
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

 @endsection
 
