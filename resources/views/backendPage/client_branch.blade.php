<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="card shadow rounded border-0 mb-3">
            <div class="card-body">
                <!-- Breadcrumb Section -->
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                        <i class="fa-solid fa-house"></i> Dashboard
                    </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                    All Branch
                    </li>
                </ol>
                </nav>

            </div>
        </div>
        <div class="card shadow rounded border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold">Client Branch List</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    + Add New Branch
                </button>
            </div>

            <!-- Branch Table -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table_container">
                          <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Client Name</th>
                                <th>Branch Name</th>
                                <th>Description</th>
                                <th width="150">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                             @forelse ($clientbranches as $index => $branch)
                                <tr>
                                    <td>{{ $index + 1 + (($clientbranches->currentPage() - 1) * $clientbranches->perPage()) }}</td>
                                    <td>{{ $branch->client->name }}</td>
                                    <td>{{ $branch->name ?? 'N/A' }}</td>
                                    <td>{{ $branch->description ?? 'N/A' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="editBranch({{$branch->id}})">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteBranch({{$branch->id}})">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted py-4" colspan="5">
                                        <i class="fa fa-inbox fa-2x mb-2"></i><br>
                                        No Branch
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                  
                </div>
                 <!-- Pagination -->
                    @if($clientbranches->hasPages())
                    <div class="mt-3">
                        {{ $clientbranches->withQueryString()->fragment('update')->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
            </div>
</div>
        </div>

        <!-- CREATE MODAL -->
        <div class="modal fade" id="createModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Branch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <!-- Client Dropdown -->
                        <div class="mb-3 position-relative">
                            <label class="form-label">Client</label>
                            <input type="hidden" id="client_id">

                            <input type="text" id="client_name" class="form-control  rounded" placeholder="Select a client" readonly style="cursor:pointer;">

                            <div class="dropdown-menu w-100 p-2" id="clientDropdown">
                                <input type="text" class="form-control rounded form-control rounded-sm mb-2" id="clientSearch" placeholder="Search clients...">
                                <div id="clientList" class="list-group list-group-flush" style="max-height:200px;overflow-y:auto;">
                                   @foreach($clients as $client)
                                        <button type="button" class="list-group-item list-group-item-action client-item" 
                                                data-id="{{ $client->id }}" 
                                                data-name="{{ $client->name }}">
                                            {{ $client->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Branch Name</label>
                            <input type="text" id="name" class="form-control rounded">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea id="branchdescription" class="form-control rounded"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" onclick="createBranch()">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- EDIT MODAL -->
        <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Branch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="edit_id">

                        <!-- Client Dropdown -->
                        <div class="mb-3 position-relative">
                            <label class="form-label">Client</label>
                            <input type="hidden" id="edit_client_id">

                            <input type="text" id="edit_client_name" class="form-control rounded" placeholder="Select a client" readonly style="cursor:pointer;">

                            <div class="dropdown-menu w-100 p-2" id="editClientDropdown">
                                <input type="text" class="form-control rounded form-control rounded-sm mb-2" id="editClientSearch" placeholder="Search clients...">
                                <div id="editClientList" class="list-group list-group-flush" style="max-height:200px;overflow-y:auto;">
                                    @foreach($clients as $client)
                                        <button type="button" class="list-group-item list-group-item-action edit-client-item" 
                                                data-id="{{ $client->id }}" 
                                                data-name="{{ $client->name }}">
                                            {{ $client->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Branch Name</label>
                            <input type="text" id="edit_name" class="form-control rounded">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea id="edit_branchdescription" class="form-control rounded"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-success" onclick="updateBranch()">Update</button>
                    </div>
                </div>
            </div>
        </div>


        <style>
            .dropdown-menu {
                display: none;
                background: #fff;
                border: 1px solid #ddd;
                border-radius: .375rem;
                box-shadow: 0 5px 15px rgba(0,0,0,.15);
                position: absolute;
                top: 100%;
                left: 0;
                z-index: 1000;
            }

            .dropdown-menu.show {
                display: block !important;
            }

            .list-group-item {
                border: none;
                cursor: pointer;
            }
        </style>

        
    </div>

@push('scripts')
<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

const clientsData = @json($clients);

// Get Client Name
function getClientNameById(id){
    let c = clientsData.find(x => x.id == id);
    return c ? c.name : "Unknown";
}

$(document).ready(function () {

    // Toggle Create Dropdown
    $('#client_name').click(function (e) {
        e.stopPropagation();
        $('#clientDropdown').toggleClass('show');
        $('#editClientDropdown').removeClass('show');
    });

    // Toggle Edit Dropdown
    $('#edit_client_name').click(function (e) {
        e.stopPropagation();
        $('#editClientDropdown').toggleClass('show');
        $('#clientDropdown').removeClass('show');
    });

    // Close dropdowns on outside click
    $(document).click(function (e) {
        if (!$(e.target).closest('#clientDropdown, #client_name').length) {
            $('#clientDropdown').removeClass('show');
        }
        if (!$(e.target).closest('#editClientDropdown, #edit_client_name').length) {
            $('#editClientDropdown').removeClass('show');
        }
    });


    // Search Create Dropdown
    $('#clientSearch').on('input', function () {
        let value = $(this).val().toLowerCase();
        $('#clientList .client-item').each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(value));
        });
    });

    // Search Edit Dropdown
    $('#editClientSearch').on('input', function () {
        let value = $(this).val().toLowerCase();
        $('#editClientList .edit-client-item').each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(value));
        });
    });

    // Select client in Create
    $(document).on('click', '#clientList .client-item', function () {
        $('#client_id').val($(this).data('id'));
        $('#client_name').val($(this).data('name'));
        $('#clientDropdown').removeClass('show');
    });

    // Select client in Edit
    $(document).on('click', '#editClientList .edit-client-item', function () {
        $('#edit_client_id').val($(this).data('id'));
        $('#edit_client_name').val($(this).data('name'));
        $('#editClientDropdown').removeClass('show');
    });

    // Load branches on start
   
});


// Create Branch
function createBranch(){

    if(!$("#client_id").val()) return Swal.fire('Warning', 'Please select a client', 'warning');
    if(!$("#name").val()) return Swal.fire('Warning', 'Please enter branch name', 'warning');

    $.post('/client-branches', {
        client_id: $("#client_id").val(),
        name: $("#name").val(),
        description: $("#branchdescription").val()
    }, function(res){

        Swal.fire({
            icon: 'success',
            title: res.message,
            timer: 1500,
            showConfirmButton: false
        });

        $("#createModal").modal('hide');

        setTimeout(()=> {
            location.reload();
        },1200);

    }).fail(function(error){
        Swal.fire('Error', error.responseJSON.message, 'error');
    });
}


// Edit Branch Load Data
function editBranch(id){
    $.get('/client-branches/' + id, function(res){
        $("#edit_id").val(res.id);
        $("#edit_client_id").val(res.client_id);
        $("#edit_client_name").val(getClientNameById(res.client_id));
        $("#edit_name").val(res.name);
        $("#edit_branchdescription").val(res.description);

        $("#editModal").modal('show');
    });
}

// Update Branch
function updateBranch(){
    let id = $("#edit_id").val();

    if(!$("#edit_client_id").val()) return Swal.fire('Warning', 'Please select a client', 'warning');
    if(!$("#edit_name").val()) return Swal.fire('Warning', 'Please enter branch name', 'warning');

    $.ajax({
        url:'/client-branches/'+id,
        type:'PUT',
        data:{
            client_id: $("#edit_client_id").val(),
            name: $("#edit_name").val(),
            description: $("#edit_branchdescription").val()
        },
        success:function(res){
            Swal.fire({
                icon:'success',
                title:res.message,
                timer:1500,
                showConfirmButton:false
            });

            $("#editModal").modal('hide');

            setTimeout(()=> {
                location.reload();
            },1200);
        },
        error: function(error){
            Swal.fire('Error', error.responseJSON.message, 'error');
        }
    });
}


// Delete Branch
function deleteBranch(id){

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url:'/client-branches/'+id,
                type:'DELETE',
                success:function(res){

                    Swal.fire({
                        icon:'success',
                        title:res.message,
                        timer:1200,
                        showConfirmButton:false
                    });

                    setTimeout(()=> {
                        location.reload();
                    },1200);

                },
                error: function(error){
                    Swal.fire('Error', error.responseJSON.message, 'error');
                }
            });

        }

    });

}

</script>

@endpush
</x-app-layout>


