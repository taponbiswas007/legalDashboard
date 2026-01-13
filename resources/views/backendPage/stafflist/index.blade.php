<x-app-layout>
    <div class="py-4 px-1 body_area">
         <div class="card shadow rounded border-0 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <!-- Breadcrumb Section -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-house"></i> Dashboard
                            </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                            Staff List
                            </li>
                        </ol>
                    </nav>
                      <a href="{{ route('stafflist.create') }}" class="btn btn-primary">Add staff</a>
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
                @if (session('error'))
                    <script>
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: '{{ session('error') }}',
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

                <div class="table_container">
                    <table>
                        <thead>
                            <tr>
                                <th>S/L No</th>
                                <th>Name</th>
                                <th>Mobile Number</th>
                                <th>Whats app number</th>
                                <th>Email</th>
                                <th>Educational Qualification</th>
                                <th>Possition</th>
                                <th>Address</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stafflists->reverse() as  $stafflist)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $stafflist->name }}</td>
                                    <td>{{ $stafflist->number }}</td>
                                    <td>{{ $stafflist->whatsapp }}</td>
                                    <td>{{ $stafflist->email }}</td>
                                    <td>{{ $stafflist->qualification }}</td>
                                    <td>{{ $stafflist->possition }}</td>
                                    <td>{{ $stafflist->address }}</td>
                                    <td>
                                        <img style="height: 50px; width:100px; border-radius:7px" src="{{ asset('images/' . $stafflist->image) }}" alt="">
                                    </td>
                                    <td>
                                        {!! $stafflist->status == 1 ? '<span class="running">Visible</span>' : '<span class="dismiss">hidden</span>' !!}
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-primary"
                                            href="{{ route('stafflist.edit', $stafflist->id) }}">Edit</a>
                                        <a class="btn btn-outline-primary"
                                            href="{{ route('stafflist.show', $stafflist->id) }}">show</a>

                                        <form id="delete-form-{{ $stafflist->id }}"
                                            action="{{ route('stafflist.destroy', $stafflist->id) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-700 confirmDelete"
                                                data-id="{{ $stafflist->id }}"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="11">No data here</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
