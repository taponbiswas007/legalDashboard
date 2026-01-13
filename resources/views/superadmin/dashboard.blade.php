@extends('superadmin.layouts.master')

@section('content')
    <div class="container mt-5">
        <h1>Super Admin Dashboard</h1>
        <hr>
        <h2>User Approval Requests</h2>
        {{-- User approval table will be loaded here --}}
        <div id="user-approval-table">
            {{-- Table of users pending approval will be rendered here by backend --}}
        </div>
    </div>
@endsection
