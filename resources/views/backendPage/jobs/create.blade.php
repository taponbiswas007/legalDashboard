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
                            <li class="breadcrumb-item">
                                <a href="{{ route('jobs.index') }}" class="text-decoration-none text-dark">
                                    Job Circulars
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Post New Job
                            </li>
                        </ol>
                    </nav>
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary addBtn">
                        View Job Circulars
                    </a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validation Error!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow rounded border-0">
            <div class="card-body">
                <div class="add_case_area">
                    <form id="jobForm" action="{{ route('jobs.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form_group">
                                    <input type="text" class="@error('title') is-invalid @enderror" id="title"
                                        name="title" value="{{ old('title') }}" placeholder="Job Title" required>
                                    <label class="form_label">Job Title <span class="text-danger">*</span></label>
                                </div>
                                @error('title')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form_group">
                                    <input type="text" class="@error('job_type') is-invalid @enderror" id="job_type"
                                        name="job_type" placeholder="Full-time, Part-time, Contract"
                                        value="{{ old('job_type') }}">
                                    <label class="form_label">Job Type</label>
                                </div>
                                @error('job_type')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form_group">
                                    <input type="text" class="@error('location') is-invalid @enderror" id="location"
                                        name="location" placeholder="Location" value="{{ old('location') }}">
                                    <label class="form_label">Location</label>
                                </div>
                                @error('location')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form_group">
                                    <input type="text" class="@error('salary_range') is-invalid @enderror"
                                        id="salary_range" name="salary_range" placeholder="e.g., 30,000 - 50,000 BDT"
                                        value="{{ old('salary_range') }}">
                                    <label class="form_label">Salary Range</label>
                                </div>
                                @error('salary_range')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form_group">
                                    <input type="date" class="@error('deadline') is-invalid @enderror" id="deadline"
                                        name="deadline" value="{{ old('deadline') }}" required>
                                    <label class="form_label">Application Deadline <span
                                            class="text-danger">*</span></label>
                                </div>
                                @error('deadline')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form_group">
                                    <input type="file" class="@error('pdf_file') is-invalid @enderror" id="pdf_file"
                                        name="pdf_file" accept=".pdf">
                                    <label class="form_label">Job Circular PDF (Optional)</label>
                                    <small class="form-text text-muted d-block mt-1">Maximum file size: 10MB</small>
                                </div>
                                @error('pdf_file')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form_group">
                                    <textarea class="@error('description') is-invalid @enderror" id="description" name="description" rows="6"
                                        placeholder="Job Description" required>{{ old('description') }}</textarea>
                                    <label class="form_label">Job Description <span
                                            class="text-danger">*</span></label>
                                </div>
                                @error('description')
                                    <p class="m-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is_published"
                                        name="is_published" value="1"
                                        {{ old('is_published') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_published">
                                        Publish immediately (visible to public)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="saveButton" class="mt-4 save btn btn-primary">
                            <i class="fa-solid fa-save"></i> Post Job
                        </button>
                        <a href="{{ route('jobs.index') }}" class="btn btn-secondary mt-4">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.tiny.cloud/1/cjxdmzyrz26zbpfrt7ztznzakvua2wq2o8dsx3mq1sqvy8qj/tinymce/6/tinymce.min.js">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '#description',
                plugins: 'lists link image codesample',
                toolbar: 'formatselect | bold italic | bullist numlist | link image | codesample',
                height: 300,
                setup: function(editor) {
                    editor.on('change', function() {
                        editor.save();
                    });
                }
            });

            const form = document.getElementById('jobForm');
            const saveButton = document.getElementById('saveButton');

            saveButton.addEventListener('click', function() {
                if (tinymce.get('description')) {
                    tinymce.get('description').save();
                }

                Swal.fire({
                    title: 'Confirm',
                    text: 'Are you sure you want to post this job?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Post Job',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        saveButton.disabled = true;
                        saveButton.innerHTML =
                            '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>
