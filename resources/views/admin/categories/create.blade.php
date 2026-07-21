@extends('layouts.admin')

@section('content')

<div class="dashboard">

    <div class="welcome mb-4">
        <h2>Add Category</h2>
        <p>Create a new category for your store products.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-custom">

        <h4 class="mb-2 fw-bold">Category Details</h4>
        <p class="text-muted mb-4">
            Enter a category name to organize your products efficiently.
        </p>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label fw-semibold">Category Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-control form-control-lg"
                    placeholder="Enter category name..."
                    required>
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill">
                <i class="fa-solid fa-plus me-2"></i>
                Add Category
            </button>

            <a href="{{ route('admin.categories.index') }}"
               class="btn btn-light px-4 py-2 rounded-pill ms-2">
                Cancel
            </a>

        </form>

    </div>

</div>

<style>

.dashboard{
    padding:20px;
}

.welcome h2{
    margin:0;
    font-size:32px;
    font-weight:700;
    color:#111827;
}

.welcome p{
    margin-top:6px;
    color:#6b7280;
    font-size:15px;
}

.card-custom{
    background:#fff;
    border-radius:16px;
    padding:30px;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
}

.form-label{
    color:#374151;
    margin-bottom:8px;
}

.form-control{
    border-radius:12px;
    border:1px solid #d1d5db;
    padding:12px 16px;
}

.form-control:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 .2rem rgba(37,99,235,.15);
}

.btn-primary{
    background:#2563eb;
    border:none;
    font-weight:600;
    box-shadow:0 4px 12px rgba(37,99,235,.25);
}

.btn-primary:hover{
    background:#1d4ed8;
    color:#fff;
}

.btn-light{
    border:1px solid #d1d5db;
    font-weight:600;
}

.rounded-pill{
    border-radius:50px !important;
}

</style>

@endsection