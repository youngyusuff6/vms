@extends('layouts.resident')
@section('title')Visitors Registration @endsection
@section('page-title') Pre-register Visitor @endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <hr>
            <form method="POST" action="{{route('resident.visitor.registeration')}}">
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <span class="text-red">*</span>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              
                <div class="form-group">
                    <label for="email">Email:</label>
                    <span class="text-red">*</span>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <span class="text-red">*</span>
                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" required value="{{ old('phone') }}">
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              
                <div class="form-group">
                    <label for="purpose">Purpose:</label>
                    <span class="text-red">*</span>
                    <textarea name="purpose" id="purpose" class="form-control @error('purpose') is-invalid @enderror" rows="4" required>{{ old('purpose') }}</textarea>
                    @error('purpose')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="visit_date">Visit Date</label>
                    <span class="text-red">*</span>
                    <input type="date" class="form-control @error('visit_date') is-invalid @enderror" id="visit_date" name="visit_date" required value="{{ old('visit_date') }}">
                    @error('visit_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            
                <div class="form-group">
                    <label for="visit_time">Visit Time</label>
                    <span class="text-red">*</span>
                    <input type="time" class="form-control @error('visit_time') is-invalid @enderror" id="visit_time" name="visit_time" required value="{{ old('visit_time') }}">
                    @error('visit_time')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection
