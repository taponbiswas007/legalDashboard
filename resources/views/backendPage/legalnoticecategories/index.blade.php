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
                            Legal Notice Category List
                            </li>
                        </ol>
                    </nav>
                     <a href="{{ route('legalnoticecategories.create') }} " class="btn btn-primary addBtn">
                        +Add L/N Category
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
        <div class="table_container">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>S/L No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="clientTable">
                    @forelse ($legalNoticeCategories as $legalNoticeCategory)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="client-name">{{ $legalNoticeCategory->name }}</td>
                            <td>
                                <p>{{ $legalNoticeCategory->description}}</p>
                            </td>
                            <td>
                                <!-- <a class="btn btn-outline-primary"
                                    href="{{ route('legalnoticecategories.show', Crypt::encrypt($legalNoticeCategory->id)) }}">Show</a> -->
                                <a class="btn btn-outline-primary"
                                    href="{{ route('legalnoticecategories.edit', Crypt::encrypt($legalNoticeCategory->id)) }}">Edit</a>
                                <!--<form id="delete-form-{{ $legalNoticeCategory->id }}"-->
                                <!--    action="{{ route('legalnoticecategories.destroy', $legalNoticeCategory->id) }}" method="post"-->
                                <!--    class="d-inline">-->
                                <!--    @csrf-->
                                <!--    @method('DELETE')-->
                                <!--    <button type="button" class="text-red-700 confirmDelete"-->
                                <!--        data-id="{{ $legalNoticeCategory->id }}"><i class="fa-solid fa-trash"></i></button>-->
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
             {{ $legalNoticeCategories->links() }}



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
