@extends('backendPage.addclient.create')

@section('name_value')
    {{ old('name', $data['name'] ?? '') }}
@endsection
@section('email_value')
    {{ old('email', $data['email'] ?? '') }}
@endsection
@section('number_value')
    {{ old('number', $data['number'] ?? '') }}
@endsection
@section('address_value')
    {{ old('address', $data['address'] ?? '') }}
@endsection

@section('form_fields_override')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('name').value = @json(old('name', $data['name'] ?? ''));
            document.getElementById('email').value = @json(old('email', $data['email'] ?? ''));
            document.getElementById('number').value = @json(old('number', $data['number'] ?? ''));
            document.getElementById('address').value = @json(old('address', $data['address'] ?? ''));
        });
    </script>
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('manager.company.dashboard') }}" class="text-decoration-none text-dark">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit &amp; Resubmit Client Request
            </li>
        </ol>
    </nav>
@endsection

@section('form_action')
    action="{{ route('manager.addclient.request.update', $approval->id) }}"
@endsection

@section('back_button')
    <a href="{{ route('manager.addclient.rejected') }}" class="btn btn-outline-primary">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
@endsection

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Edit &amp; Resubmit Client Request</h2>
        <form method="POST" @yield('form_action')>
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $data['name'] ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', $data['email'] ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="number" class="form-label">Number</label>
                <input type="text" class="form-control" id="number" name="number"
                    value="{{ old('number', $data['number'] ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address"
                    value="{{ old('address', $data['address'] ?? '') }}" required>
            </div>
            <button type="submit" class="btn btn-success">Resubmit for Approval</button>
            <a href="{{ route('manager.addclient.rejected') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
