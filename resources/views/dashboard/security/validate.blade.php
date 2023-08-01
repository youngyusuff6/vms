@extends('layouts.security')
@section('title', 'Validate Visitors')
@section('page-title', 'Validate Visitors')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('security.visitor.validate') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Enter Visitor ID" name="search" value="{{ request()->query('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
