@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Update your profile</h4>
                </div>
                <div class="card-body">
                    <p class="mb-0">After creating your account, it's a good idea to update your profile with any additional information.</p>

                    <div class="mt-3 d-flex justify-content-between">
                        <a href="{{ route('entities.edit', Auth::user()->entity) }}" class="btn btn-primary">Update your profile</a>
                        <a href="{{ route('members.index') }}" class="btn btn-link">Skip for now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
