<x-app-layout>
    <div class="container">
        <h2 class="mb-4">Company Dashboard</h2>
        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title">Company Owner: {{ $company->name }}</h4>
                <p class="card-text">Email: {{ $company->email }}</p>
            </div>
        </div>
        <!-- Add company-specific data, resources, and management tools here -->
        <div class="alert alert-info">You have access to manage your company's data and resources here.</div>
    </div>
</x-app-layout>
