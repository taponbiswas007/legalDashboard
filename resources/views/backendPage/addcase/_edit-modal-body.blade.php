 <style>
     /* Hide next_hearing_wrap when status checkbox is unchecked */
     #status_checkbox:not(:checked)~.row #next_hearing_wrap {
         display: none !important;
     }

     /* Hide next_step area when transfer checkbox is checked */
     #transfer_checkbox_hidden:checked~.row #next_step_wrap {
         display: none !important;
     }

     /* Custom checkbox styling - unchecked state */
     .custom-checkbox-box {
         border-color: #cbd5e1 !important;
         background-color: white !important;
     }

     .custom-checkbox-check {
         opacity: 0 !important;
         transform: scale(0) !important;
     }

     .check_form_group {
         border-left: 4px solid #ef4444 !important;
     }

     .status-running {
         opacity: 0.6 !important;
     }

     .status-disposal {
         opacity: 1 !important;
     }

     /* Checked state styling */
     #status_checkbox:checked~.row .check_form_group {
         border-left-color: #10b981 !important;
     }

     #status_checkbox:checked~.row .check_form_group .custom-checkbox-box {
         border-color: #10b981 !important;
         background-color: #10b981 !important;
     }

     #status_checkbox:checked~.row .check_form_group .custom-checkbox-check {
         opacity: 1 !important;
         transform: scale(1) !important;
     }

     #status_checkbox:checked~.row .check_form_group .status-running {
         opacity: 1 !important;
     }

     #status_checkbox:checked~.row .check_form_group .status-disposal {
         opacity: 0.6 !important;
     }

     .case_status {
         display: block !important;
     }

     #status_checkbox:checked~.row .check_form_group .case_status {
         display: none !important;
     }

     #transfer_checkbox:checked~.row #next_step_wrap {
         display: none !important;
     }

     /* Styling for disabled transfer checkbox */
     #transfer_checkbox_visible:disabled {
         opacity: 0.5 !important;
         cursor: not-allowed !important;
     }

     #transfer_checkbox_visible:disabled+label {
         opacity: 0.5 !important;
         cursor: not-allowed !important;
     }

     /* Dropdown positioning fix */
     .form_group.position-relative {
         position: relative !important;
     }

     .form_group .dropdown-menu {
         position: absolute !important;
         top: 100% !important;
         left: 0 !important;
         z-index: 1050 !important;
         margin-top: 0.125rem !important;
         transform: unset !important;
     }

     .form_group .dropdown-menu.show {
         display: block !important;
     }
 </style>
 <form id="updateCaseForm" enctype="multipart/form-data">
     @csrf
     @method('PUT')
     <input type="hidden" name="case_id" value="{{ $addcase->id }}">

     {{-- Status checkbox moved here for CSS sibling selector to work --}}
     <input type="hidden" name="status" value="0">
     <input type="checkbox" name="status" value="1" id="status_checkbox"
         {{ $addcase->status == 1 ? 'checked' : '' }} style="display:none;">

     {{-- Transfer checkbox moved here for CSS sibling selector to work --}}
     <input type="checkbox" name="transfer_checkbox" id="transfer_checkbox" style="display:none;">

     <div class="row g-4">
         <div class="col-12">
             <div class="check_form_group p-2"
                 style="
                        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                        border-radius: 12px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                        border: 1px solid #e2e8f0;
                        transition: all 0.3s ease;
                    ">
                 {{-- Visual label for hidden checkbox --}}
                 <label for="status_checkbox" class="d-flex align-items-center"
                     style="
                            cursor: pointer;
                            user-select: none;
                            padding: 8px 12px;
                            border-radius: 8px;
                            transition: background-color 0.2s;
                        ">
                     <span class="custom-checkbox-box me-3"
                         style="
                                position: relative;
                                width: 28px;
                                height: 28px;
                                border-radius: 6px;
                                background: white;
                                border: 2px solid #cbd5e1;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                transition: all 0.3s ease;
                            ">
                         <span class="custom-checkbox-check"
                             style="
                                    opacity: 0;
                                    transform: scale(0);
                                    transition: all 0.3s ease;
                                    color: white;
                                    font-size: 16px;
                                    font-weight: bold;
                                ">
                             ✓
                         </span>
                     </span>
                     <span
                         style="
                                font-weight: 600;
                                font-size: 1.1rem;
                                color: #334155;
                            ">Case
                         Status</span>

                     <!-- Hidden actual checkbox -->
                     <input type="checkbox" id="status_checkbox" style="display: none;">
                 </label>

                 <div class="mt-3 d-flex flex-column flex-md-row justify-content-md-between"
                     style="
                            gap: 1rem;
                            padding: 12px 16px;
                            background: white;
                            border-radius: 8px;
                            border-left: 4px solid #cbd5e1;
                        ">
                     <div class=" status-running"
                         style="
                                display: flex;
                                align-items: center;
                                gap: 8px;
                            ">
                         <span
                             style="
                                    display: inline-block;
                                    width: 12px;
                                    height: 12px;
                                    border-radius: 50%;
                                    background: #10b981;
                                "></span>
                         <span style="color: #475569; font-weight: 500;">Checked = Case is Running</span>
                     </div>

                     <div class=" status-disposal"
                         style="
                                display: flex;
                                align-items: center;
                                flex-wrap: wrap;
                                gap: 8px;
                            ">
                         <div class="d-flex justify-content-start gap-2 align-items-center">
                             <span
                                 style="
                                    flex-shrink: 0;
                                    width: 12px;
                                    height: 12px;
                                    border-radius: 50%;
                                    background: #ef4444;
                                "></span>
                             <span style="color: #475569; font-weight: 500;flex-shrink: 0;">Unchecked = Case is
                                 Disposal</span>
                         </div>
                         <select class="form-select case_status w-100 rounded" name="case_status" id="case_status"
                             style="min-width: 200px">
                             <option value="Withdraw">Withdraw</option>
                             <option value="Judgement">Judgement</option>
                         </select>
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-12">
             <div class="d-flex align-items-center gap-2">
                 <input type="checkbox" id="transfer_checkbox_visible" style="margin-right: 5px;"
                     onchange="handleTransferCheckbox(this)">
                 <label for="transfer_checkbox_visible" class="mb-0 text-nowrap text-danger"
                     style="cursor: pointer;">Case Transfer</label>
             </div>
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
             <div class="form_group position-relative">
                 <label class="select_form_label" for="client_id">On behalf Of</label>
                 <input type="hidden" id="client_id" name="client_id" value="{{ $addcase->client_id }}">

                 <!-- Main input -->
                 <input type="text" id="party_name" class="form-control" placeholder="Select or type a party name"
                     readonly data-bs-toggle="dropdown" aria-expanded="false"
                     value="{{ optional($addclients->where('id', $addcase->client_id)->first())->name ?? '' }}">

                 <!-- Bootstrap dropdown -->
                 <div class="dropdown-menu shadow w-100 p-2" id="clientDropdown">
                     <!-- Search input -->
                     <input type="text" class="form-control form-control-sm mb-2" id="clientSearch"
                         placeholder="Search clients...">

                     <!-- List of clients -->
                     <div id="clientList" class="list-group list-group-flush"
                         style="max-height: 200px; overflow-y: auto;">
                         @foreach ($addclients as $addclient)
                             <button type="button" class="list-group-item list-group-item-action"
                                 data-id="{{ $addclient->id }}"
                                 onclick="selectClient('{{ $addclient->id }}', '{{ $addclient->name }}')">
                                 {{ $addclient->name }}
                             </button>
                         @endforeach
                     </div>

                     <div class="dropdown-divider"></div>
                     <div class="text-center">
                         <button type="button" class="btn btn-outline-primary btn-sm" onclick="addNewClient()">
                             <i class="fa-solid fa-user-plus me-1"></i> Add New Client
                         </button>
                     </div>
                 </div>
             </div>

             @error('client_id')
                 <p class="m-2 text-danger">{{ $message }}</p>
             @enderror
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
             <div class="form_group ">
                 <input type="text" name="file_number" id="file_name" placeholder="File number"
                     value="{{ $addcase->file_number }}">
                 <label class="form_label" for="">File number</label>
             </div>
             @error('file_number')
                 <p class="m-2 text-danger">
                     {{ $message }}
                 </p>
             @enderror
             <h1 class=" d-none" style="font-size: 12px;
                color: #000000;">
                 File Number: <br> <span style="color: rgb(21, 0, 255); font-weight: 500; font-size: 15px">
                     {{ $addcase->file_number }}</span>
             </h1>
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
             <div class="form_group ">
                 <label class="select_form_label" for="name_of_parties">Name of the parties</label>
                 <input list="parties" name="name_of_parties" id="name_of_parties"
                     placeholder="Select or type a party name" value="{{ $addcase->name_of_parties }}" />

             </div>
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
             <div class="form_group position-relative">
                 <label class="select_form_label" for="branch_id">Branch</label>
                 <input type="hidden" id="branch_id" name="branch_id" value="{{ $addcase->branch_id }}">

                 <!-- Main input -->
                 <input type="text" id="branch_name" class="form-control" placeholder="Select or type a Branch"
                     readonly data-bs-toggle="dropdown" aria-expanded="false"
                     value="{{ optional($clientbranches->where('id', $addcase->branch_id)->first())->name ?? '' }}">

                 <!-- Bootstrap dropdown -->
                 <div class="dropdown-menu shadow w-100 p-2" id="branchDropdown">
                     <!-- Search input -->
                     <input type="text" class="form-control form-control-sm mb-2" id="branchSearch"
                         placeholder="Search branch...">

                     <!-- List of clients -->
                     <!-- Your current HTML is correct -->
                     <div id="branchList" class="list-group list-group-flush"
                         style="max-height: 200px; overflow-y: auto;">
                         @foreach ($clientbranches as $clientbranch)
                             <button type="button" class="list-group-item list-group-item-action"
                                 data-id="{{ $clientbranch->id }}" data-client-id="{{ $clientbranch->client_id }}"
                                 onclick="selectBranch('{{ $clientbranch->id }}', '{{ $clientbranch->name }}')">
                                 {{ $clientbranch->name }}
                             </button>
                         @endforeach
                     </div>

                     <div class="dropdown-divider"></div>
                     <div class="text-center">
                         <button type="button" class="btn btn-outline-primary btn-sm" onclick="addNewBranch()">
                             <i class="fa-solid fa-user-plus me-1"></i> Add New Branch
                         </button>
                     </div>
                 </div>
             </div>

             @error('branch_id')
                 <p class="m-2 text-danger">{{ $message }}</p>
             @enderror
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
             <div class="form_group ">
                 <label class="select_form_label" for="loan_account_acquest_cin">
                     Loan A/C OR Member OR CIN
                 </label>
                 <input name="loan_account_acquest_cin" id="loan_account_acquest_cin"
                     placeholder="Loan A/C OR Member OR CIN" value="{{ $addcase->loan_account_acquest_cin }}" />
             </div>
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
             <div class="form_group position-relative">
                 <label class="select_form_label" for="court_id">Court Name</label>
                 <input type="hidden" id="court_id" name="court_id" value="{{ $addcase->court_id }}">

                 <!-- Main input -->
                 <input type="text" id="court_input" class="form-control"
                     placeholder="Select or type a court name" autocomplete="off"
                     value="{{ optional($courts->where('id', $addcase->court_id)->first())->name ?? '' }}">

                 <!-- Dropdown -->
                 <div class="dropdown-menu shadow w-100 p-2" id="courtDropdown">
                     <!-- Search input -->
                     <input type="text" class="form-control form-control-sm mb-2" id="courtSearch"
                         placeholder="Search courts...">

                     <!-- List of courts -->
                     <div id="courtList" class="list-group list-group-flush"
                         style="max-height: 200px; overflow-y: auto;">
                         @foreach ($courts as $court)
                             <button type="button" class="list-group-item list-group-item-action"
                                 data-id="{{ $court->id }}"
                                 onclick="selectCourt('{{ $court->id }}','{{ $court->name }}')">
                                 {{ $court->name }}
                             </button>
                         @endforeach
                     </div>

                     <div class="dropdown-divider"></div>
                     <div class="text-center">
                         <button type="button" class="btn btn-outline-primary btn-sm" onclick="addNewCourt()">
                             <i class="fa-solid fa-plus me-1"></i> Add New Court
                         </button>
                     </div>
                 </div>
             </div>

             @error('court_id')
                 <p class="m-2 text-danger">{{ $message }}</p>
             @enderror
         </div>



         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
             <div class="form_group ">
                 <input type="date" name="legal_notice_date" id="legal_notice_date"
                     value="{{ $addcase->legal_notice_date ? $addcase->legal_notice_date->format('Y-m-d') : '' }}"
                     placeholder="legal notice date">
                 <label class="form_label" for="">Legal Notice Date</label>
             </div>
             @error('legal_notice_date')
                 <p class="m-2 text-danger">
                     {{ $message }}
                 </p>
             @enderror

         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
             <div class="form_group ">
                 <input type="date" name="filing_or_received_date" id="filing_or_received_date"
                     value="{{ $addcase->filing_or_received_date ? $addcase->filing_or_received_date->format('Y-m-d') : '' }}"
                     placeholder="Filing or received date">
                 <label class="form_label" for="">Filing or received date</label>
             </div>
             @error('filing_or_received_date')
                 <p class="m-2 text-danger">
                     {{ $message }}
                 </p>
             @enderror

         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
             <div class="form_group">
                 <input type="text" id="case_number" value="{{ $addcase->case_number }}" name="case_number"
                     placeholder="Case Number">
                 <label class="form_label" for="">Case Number</label>
             </div>
             @error('case_number')
                 <p class="m-2 text-danger">
                     {{ $message }}
                 </p>
             @enderror
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
             <div class="form_group">
                 <input type="text" id="section" value="{{ $addcase->section }}" name="section"
                     placeholder="Section">
                 <label class="form_label" for="">Section</label>
             </div>
             @error('section')
                 <p class="m-2 text-danger">
                     {{ $message }}
                 </p>
             @enderror
         </div>

         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-none">
             <div class="form_group">
                 <input type="date" name="previous_date" id="previous_date"
                     value="{{ $addcase->previous_date }}" placeholder="Previous Date">
                 <label class="form_label" for="">Previous Date</label>
             </div>
             @error('previous_date')
                 <p class="m-2 text-danger">
                     {{ $message }}
                 </p>
             @enderror
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-none">
             <div class="form_group">
                 <input type="text" id="previous_step" value="{{ $addcase->previous_step }}"
                     name="previous_step" placeholder="Previous Step">
                 <label class="form_label" for="">Previous Step</label>
             </div>
             @error('previous_step')
                 <p class="m-2 text-danger">
                     {{ $message }}
                 </p>
             @enderror
         </div>




         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3" id="next_hearing_wrap">
             <div class="d-flex justify-content-between align-items-center flex-column">
                 <div class="form_group w-100">

                     <input type="date" id="next_hearing_date" name="next_hearing_date"
                         value="{{ $addcase->next_hearing_date ? $addcase->next_hearing_date->format('Y-m-d') : '' }}"
                         placeholder="Next Hearing Date">
                     <label class="form_label" for="">Next Hearing Date</label>
                 </div>
                 <div class="d-flex align-items-center gap-2 mt-1">
                     <label for="nh_checkbox" class="mb-0 ms-2 text-nowrap text-danger">Enable History Insert</label>
                     <input type="checkbox" class="ms-2 rounded" name="nh_checkbox" id="nh_checkbox" checked>
                 </div>
             </div>

             @error('next_hearing_date')
                 <p class="m-2 text-danger">{{ $message }}</p>
             @enderror
         </div>

         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3" id="next_step_wrap">
             <div class="d-flex justify-content-between align-items-center flex-column">
                 <div class="form_group w-100">
                     <input type="text" id="next_step" value="{{ $addcase->next_step }}" name="next_step"
                         placeholder="Next Step">
                     <label class="form_label" for="">Next Step</label>
                 </div>
                 <div class="d-flex align-items-center gap-2">
                     <label for="n_a_checkbox" class="mb-0 ms-2 text-nowrap text-danger">Set Previous Step</label>
                     <input type="checkbox" class="ms-2 rounded" name="n_a_checkbox" id="n_a_checkbox" checked>
                 </div>

             </div>

             @error('next_step')
                 <p class="m-2 text-danger">
                     {{ $message }}
                 </p>
             @enderror
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
             <div class="form_group">
                 <input type="file" id="legal_notice" name="legal_notice" placeholder="Legal notice">
                 <label class="form_label" for=""> Legal notice</label>
             </div>
             @error('legal_notice')
                 <p class="m-2 text-danger">
                     {{ $message }}
                 </p>
             @enderror
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
             <div class="form_group">
                 <input type="file" id="plaints" name="plaints" placeholder=" 	Plaints">
                 <label class="form_label" for=""> Plaints</label>
             </div>
             @error('plaints')
                 <p class="m-2 text-danger">
                     {{ $message }}
                 </p>
             @enderror
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
             <div class="form_group">
                 <input type="file" id="others_documents" name="others_documents"
                     placeholder=" 	Others Documents">
                 <label class="form_label" for=""> Others Documents</label>
             </div>
             @error('others_documents')
                 <p class="m-2 text-danger">
                     {{ $message }}
                 </p>
             @enderror
         </div>
         <!-- <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="check_form_group">
                    <input class="" type="checkbox" name="status"
                        {{ $addcase->status == 1 ? 'checked' : '' }}>
                    <p>Checked =Case is Running <br> unchecked = Case is disposal</p>
                </div>
            </div> -->



     </div>
     <div class="d-flex justify-content-end mt-4">
         <button data-bs-dismiss="modal" type="submit" id="saveButton"
             class="mt-6 save btn btn-primary">Update</button>
     </div>
 </form>
