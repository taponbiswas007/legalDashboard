<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="py-4 d-sm-flex justify-content-between align-items-center">
            <h1 class="mb-4 mb-sm-0">Blog list</h1>

            <a href="{{ route('blog.create') }}" class="btn btn-primary">Add new</a>
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
                        <th>Category</th>
                        <th>Content</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($blogs->reverse() as  $blog)
                        <tr>
                            <td>1</td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->category }}</td>
                            <td class="overflow-hidden" style="width: 200px; heigh: 100px">{!! $blog->content !!}</td>

                            <td>
                                <img style="height: 50px; width:100px; border-radius:7px"
                                    src="{{ asset('images/' . $blog->image) }}" alt="">
                            </td>

                            <td>
                                {!! $blog->status == 1 ? '<span class="running">Visible</span>' : '<span class="dismiss">hidden</span>' !!}

                            </td>
                            <td>
                                <a class="btn btn-outline-primary" href="{{ route('blog.edit', $blog->id) }}">Edit</a>
                                <a class="btn btn-outline-primary" href="{{ route('blog.show', $blog->id) }}">show</a>

                                <form id="delete-form-{{ $blog->id }}"
                                    action="{{ route('blog.destroy', $blog->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-700 confirmDelete"
                                        data-id="{{ $blog->id }}"><i class="fa-solid fa-trash"></i></button>
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
