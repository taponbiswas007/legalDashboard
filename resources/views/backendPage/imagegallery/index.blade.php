<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="py-4 d-sm-flex justify-content-between align-items-center">
            <h1 class="mb-4 mb-sm-0">Image Gallery</h1>

            <a href="{{ route('imagegallery.create') }}" class="btn btn-primary">Add new</a>
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
                        <th>title</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($imagegalleries->reverse() as  $imagegallery)
                        <tr>
                            <td>1</td>
                            <td>{{ $imagegallery->title }}</td>


                            <td>
                                <img style="height: 50px; width:100px; border-radius:7px"
                                    src="{{ asset('images/' . $imagegallery->image) }}" alt="">
                            </td>

                            <td>
                                {!! $imagegallery->status == 1 ? '<span class="running">Visible</span>' : '<span class="dismiss">hidden</span>' !!}

                            </td>
                            <td>
                                <a class="btn btn-outline-primary"
                                    href="{{ route('imagegallery.edit', $imagegallery->id) }}">Edit</a>
                                <a class="btn btn-outline-primary"
                                    href="{{ route('imagegallery.show', $imagegallery->id) }}">show</a>

                                <form id="delete-form-{{ $imagegallery->id }}"
                                    action="{{ route('imagegallery.destroy', $imagegallery->id) }}" method="post"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-700 confirmDelete"
                                        data-id="{{ $imagegallery->id }}"><i class="fa-solid fa-trash"></i></button>
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
</x-app-layout>
