@extends('backendPage.addclient.show')

@section('back_button')
    <a href="{{ route('manager.addclient.requests') }}" class="btn btn-outline-primary">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
@endsection

@section('case_tabs')
    {{-- Optionally override or hide case tabs for manager if needed --}}
@endsection
