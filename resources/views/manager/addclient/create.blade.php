@extends('backendPage.addclient.create')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('manager.company.dashboard') }}" class="text-decoration-none text-dark">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Request New Client
            </li>
        </ol>
    </nav>
@endsection

@section('client_list_button')
    <a href="{{ route('manager.addclient.requests') }}" class="btn btn-primary addBtn">
        View My Requests
    </a>
@endsection

@section('form_action')
    action="{{ route('manager.addclient.request.store') }}"
@endsection

@section('back_button')
    <a href="{{ route('manager.company.dashboard') }}" class="btn btn-outline-primary">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
@endsection
