@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Create New Job</h2>

        <!-- Success & Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('jobs.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Job Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Min Salary</label>
                            <input type="number" name="min_salary" class="form-control" value="{{ old('min_salary') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Max Salary</label>
                            <input type="number" name="max_salary" class="form-control" value="{{ old('max_salary') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Job Type</label>
                        <select name="job_type" class="form-select" required>
                            <option value="full-time">Full-Time</option>
                            <option value="part-time">Part-Time</option>
                            <option value="contract">Contract</option>
                            <option value="freelance">Freelance</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Locations</label>
                        <select name="location_ids[]" class="form-select" multiple style="border: 1px solid #ccc; background: white; color: black;">
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">
                                    {{ $location->city }}, {{ $location->state }}, {{ $location->country }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Languages</label>
                        <select name="language_ids[]" class="form-select" multiple>
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Attributes</label>
                        @foreach($attributes as $attribute)
                            <div class="input-group mb-2">
                                <label class="input-group-text">{{ $attribute->name }}</label>
                                <input type="text" class="form-control attribute-input"
                                       data-id="{{ $attribute->id }}"
                                       placeholder="Enter value">
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Published At</label>
                        <input type="datetime-local" name="published_at" class="form-control" required>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_remote" class="form-check-input" value="1">
                        <label class="form-check-label">Remote</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Create Job</button>
                </form>
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("job-form").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent default form submission

            let form = event.target;
            let formData = new FormData(form);

            // Collect only attributes with values
            let attributes = [];
            document.querySelectorAll(".attribute-input").forEach((input) => {
                let id = input.dataset.id;
                let value = input.value.trim();

                if (value !== "") { // Only add attributes that have values
                    attributes.push({ id: parseInt(id), value: value });
                }
            });

            // Convert form data to JSON object
            let jobData = Object.fromEntries(formData.entries());

            // Convert multi-select values to arrays
            jobData.location_ids = formData.getAll("location_ids[]").map(Number);
            jobData.language_ids = formData.getAll("language_ids[]").map(Number);
            jobData.attributes = attributes; // Assign only non-empty attributes

            // Send the request
            fetch(form.action, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(jobData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                        window.location.href = "/jobs"; // Redirect after success
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    });
</script>
