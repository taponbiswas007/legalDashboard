<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="py-4 d-sm-flex justify-content-between align-items-center">
            <h1 class="mb-4 mb-sm-0">Trusted clients list</h1>

            <a href="{{ route('trustedclient.create') }}" class="btn btn-primary">Add new</a>
        </div>
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


        <div class="table_container">
            <table>
                <thead>
                    <tr>
                        <th>S/L No</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trustedclients->reverse() as  $trustedclient)
                        <tr>
                            <td>1</td>
                            <td>
                                <img style="height: 100px; width:100px; border-radius:7px"
                                    src="{{ asset($trustedclient->image) }}" alt="">
                            </td>

                            <td>
                                {!! $trustedclient->status == 1 ? '<span class="running">Visible</span>' : '<span class="dismiss">hidden</span>' !!}

                            </td>
                            <td>
                                <a class="btn btn-outline-primary"
                                    href="{{ route('trustedclient.edit', $trustedclient->id) }}">Edit</a>
                                <a class="btn btn-outline-primary"
                                    href="{{ route('trustedclient.show', $trustedclient->id) }}">show</a>

                                <form id="delete-form-{{ $trustedclient->id }}"
                                    action="{{ route('trustedclient.destroy', $trustedclient->id) }}" method="post"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-700 confirmDelete"
                                        data-id="{{ $trustedclient->id }}"><i class="fa-solid fa-trash"></i></button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="4">No data here</td>
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
</x-app-layout>
