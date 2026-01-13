@extends('backendPage.addclient.index')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('manager.company.dashboard') }}" class="text-decoration-none text-dark">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                My Client Requests
            </li>
        </ol>
    </nav>
@endsection

@section('add_client_button')
    <a href="{{ route('manager.addclient.request.create') }}" class="btn btn-primary addBtn">
        +Request New Client
    </a>
@endsection

@section('table_data')
    <tbody id="clientTable">
        @forelse ($addclients as $index => $addclient)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="client-name">{{ $addclient->name }}</td>
                <td><a href="tel:{{ $addclient->number }}">{{ $addclient->number }}</a></td>
                <td><a href="mailto:{{ $addclient->email }}">{{ $addclient->email }}</a></td>
                <td>{{ $addclient->address }}</td>
                <td>
                    {!! $addclient->status == 1 ? '<span class="running">Running</span>' : '<span class="dismiss">Dismiss</span>' !!}
                </td>
                <td>
                    <a class="btn btn-outline-primary"
                        href="{{ route('manager.addclient.request.show', Crypt::encrypt($addclient->id)) }}">Show</a>
                    @if ($addclient->is_editable)
                        <a class="btn btn-outline-primary"
                            href="{{ route('manager.addclient.request.edit', Crypt::encrypt($addclient->id)) }}">Edit</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td class="text-center" colspan="7">No data here</td>
            </tr>
        @endforelse
    </tbody>
@endsection
