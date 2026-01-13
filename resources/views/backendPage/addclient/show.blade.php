<x-app-layout>
    <div class="py-4 px-1 body_area">
        {{-- ========== CLIENT INFO CARD ========== --}}
        <div class="card shadow border-0 mb-3">
            <div class="card-body">
                <div class="mb-4">
                    <a href="{{ route('addclient.index') }}" class="btn btn-outline-primary">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </a>
                </div>

                <div
                    class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4">
                    <h1 class="text-uppercase mb-3 mb-sm-0">{{ $addclient->name }}</h1>
                    <span class="btn {{ $addclient->status == 1 ? 'btn-success' : 'btn-danger' }} text-white">
                        {{ $addclient->status == 1 ? 'Active' : 'Deactive' }}
                    </span>
                </div>

                <hr>

                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <h5 class="fw-bold">Mobile Number:</h5>
                        <a href="tel:{{ $addclient->number }}" class="text-decoration-none">{{ $addclient->number }}</a>
                    </div>

                    <div class="col-12 col-md-6">
                        <h5 class="fw-bold">Email:</h5>
                        <a href="mailto:{{ $addclient->email }}"
                            class="text-decoration-none">{{ $addclient->email }}</a>
                    </div>

                    <div class="col-12">
                        <h5 class="fw-bold">Address:</h5>
                        <p>{{ $addclient->address }}</p>
                    </div>

                    <div class="col-12 col-md-6">
                        <h5 class="fw-bold">Added On:</h5>
                        <p>{{ $addclient->created_at->format('d-M-Y H:i:s a') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== CASE LIST CARD ========== --}}
        <div class="card shadow border-0">
            <div class="card-body">
                {{-- Top Buttons --}}
                <div class="d-flex justify-content-end gap-3 flex-wrap mb-3">
                    <div>
                        <button class="btn btn-outline-secondary" data-bs-toggle="offcanvas"
                            data-bs-target="#filterCanvas">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                    </div>
                    <div>
                        <a href="#" id="exportPdfBtn" class="btn btn-danger">
                            <i class="fa fa-file-pdf"></i> PDF
                        </a>
                        <a href="#" id="exportExcelBtn" class="btn btn-success ">
                            <i class="fa fa-file-excel"></i> Excel
                        </a>
                    </div>
                </div>

                {{-- Tabs --}}
                <ul class="nav nav-tabs" id="caseTabs">
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'running' ? 'active' : '' }}" data-bs-toggle="tab"
                            href="#runningTab" data-tab="running">
                            Running Cases <span class="fw-bold">({{ $runningCases->total() }})</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'disposal' ? 'active' : '' }}" data-bs-toggle="tab"
                            href="#disposalTab" data-tab="disposal">
                            Disposal Cases <span class="fw-bold">({{ $disposalCases->total() }})</span>
                        </a>
                    </li>
                </ul>

                {{-- Tab Contents --}}
                <div class="tab-content mt-3">
                    <input type="hidden" id="activeTab" value="{{ $activeTab ?? 'running' }}">

                    <div id="runningTab" class="tab-pane fade {{ $activeTab === 'running' ? 'show active' : '' }}">
                        @include('backendPage.addclient.partials.case_table', [
                            'cases' => $runningCases,
                            'tab' => 'running',
                            'perPage' => $perPage,
                        ])
                    </div>

                    <div id="disposalTab" class="tab-pane fade {{ $activeTab === 'disposal' ? 'show active' : '' }}">
                        @include('backendPage.addclient.partials.case_table', [
                            'cases' => $disposalCases,
                            'tab' => 'disposal',
                            'perPage' => $perPage,
                        ])
                    </div>
                </div>

                {{-- Offcanvas Filter --}}
                <div class="offcanvas offcanvas-end" tabindex="-1" id="filterCanvas">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title">Filter Cases</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <form method="GET" class="offcanvas-body">
                        <input type="hidden" name="tab" id="filterActiveTab" value="{{ $activeTab }}">

                        @foreach ([
        'file_number' => 'File Number',
        'name_of_parties' => 'Name of Parties',
        'court_name' => 'Court Name',
        'case_number' => 'Case Number',
        'section' => 'Section',
        'legal_notice_date' => 'Legal Notice Date',
        'filing_or_received_date' => 'Filing / Received Date',
        'previous_date' => 'Previous Date',
        'next_hearing_date' => 'Next Hearing Date',
    ] as $name => $label)
                            <div class="mb-3">
                                <label class="form-label">{{ $label }}</label>
                                <input type="{{ str_contains($name, 'date') ? 'date' : 'text' }}"
                                    name="{{ $name }}" value="{{ request($name) }}"
                                    class="form-control rounded">
                            </div>
                        @endforeach

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
                            <a href="{{ request()->url() }}?tab={{ $activeTab }}"
                                class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- =================== SCRIPTS =================== --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const activeTabInput = document.getElementById('activeTab');
            const filterActiveTab = document.getElementById('filterActiveTab');
            const tabLinks = document.querySelectorAll('#caseTabs a[data-bs-toggle="tab"]');

            tabLinks.forEach(link => {
                link.addEventListener('shown.bs.tab', function(e) {
                    const selectedTab = e.target.getAttribute('data-tab');
                    activeTabInput.value = selectedTab;
                    filterActiveTab.value = selectedTab;
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const pdfBtn = document.getElementById('exportPdfBtn');
            const excelBtn = document.getElementById('exportExcelBtn');
            const activeTabInput = document.getElementById('activeTab');

            const basePdfUrl = "{{ route('client.export.pdf', Crypt::encrypt($addclient->id)) }}";
            const baseExcelUrl = "{{ route('client.export.excel', Crypt::encrypt($addclient->id)) }}";

            pdfBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const activeTab = activeTabInput.value;
                const params = new URLSearchParams(window.location.search);
                params.set('tab', activeTab);
                window.location.href = `${basePdfUrl}?${params.toString()}`;
            });

            excelBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const activeTab = activeTabInput.value;
                const params = new URLSearchParams(window.location.search);
                params.set('tab', activeTab);
                window.location.href = `${baseExcelUrl}?${params.toString()}`;
            });

            // Delete file with SweetAlert confirmation
            window.deleteFile = function(deleteUrl, fileType) {
                Swal.fire({
                    title: 'আপনি কি নিশ্চিত?',
                    text: `আপনি ${fileType} ফাইলটি মুছতে চান?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'হ্যাঁ, মুছুন!',
                    cancelButtonText: 'বাতিল'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(deleteUrl, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'মুছে ফেলা হয়েছে!',
                                        text: data.message,
                                        icon: 'success'
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'ত্রুটি!',
                                        text: data.message || 'ফাইল মুছতে সমস্যা হয়েছে।',
                                        icon: 'error'
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: 'ত্রুটি!',
                                    text: 'সার্ভার সমস্যা হয়েছে।',
                                    icon: 'error'
                                });
                            });
                    }
                });
            }
        });
    </script>
</x-app-layout>
