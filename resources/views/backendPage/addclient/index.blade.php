<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="card shadow rounded border-0 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                     <!-- Breadcrumb Section -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-house"></i> Dashboard
                            </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                            Client list
                            </li>
                        </ol>
                    </nav>
                     <a href="{{ route('addclient.create') }} " class="btn btn-primary addBtn">
                        +Add Client
                    </a>
                </div>
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-body">
                 @if (session('success'))
            <script>
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: '{{ session('success') }}',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            </script>
        @endif

        <div class="d-flex justify-between align-items-center gap-4">
            <button class="mb-4 btn btn-primary" id="printButton">Print</button>
            <div class="mb-4 filter_box mb-sm-0">
                <div class="form_group">
                    <input type="Search" id="searchBox" placeholder="Search here...">
                    <label class="form_label" for="searchBox">Search here...</label>
                </div>
            </div>
        </div>
        <div class="table_container">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>S/L No</th>
                        <th>Name</th>
                        <th>Mobile number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
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
                                    href="{{ route('addclient.show', Crypt::encrypt($addclient->id)) }}">Show</a>
                                <a class="btn btn-outline-primary"
                                    href="{{ route('addclient.edit', Crypt::encrypt($addclient->id)) }}">Edit</a>
                                <!--<form id="delete-form-{{ $addclient->id }}"-->
                                <!--    action="{{ route('addclient.destroy', $addclient->id) }}" method="post"-->
                                <!--    class="d-inline">-->
                                <!--    @csrf-->
                                <!--    @method('DELETE')-->
                                <!--    <button type="button" class="text-red-700 confirmDelete"-->
                                <!--        data-id="{{ $addclient->id }}"><i class="fa-solid fa-trash"></i></button>-->
                                <!--</form>-->

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="7">No data here</td>
                        </tr>
                    @endforelse



                </tbody>
            </table>
            {{-- {{ $addclients->links() }} --}}



            <script>
                document.querySelectorAll('.confirmDelete').forEach(function(button) {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();

                        const herocontentId = this.getAttribute('data-id');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('delete-form-' + herocontentId).submit();
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                            }
                        });
                    });
                });
            </script>

        </div>
            </div>
        </div>
       
    </div>
</x-app-layout>
