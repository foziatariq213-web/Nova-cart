@extends('layouts.admin')

@section('content')

<div class="dashboard">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div class="welcome">
            <h2>Categories</h2>
            <p>Manage all your product categories</p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="btn btn-primary px-4 py-2 rounded-pill">
            <i class="fa-solid fa-plus me-2"></i>
            Add Category
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-custom">

        <table class="table table-hover align-middle mb-0">

            <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-center" width="180">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($categories as $cat)

                    <tr>

                        <td class="fw-semibold">
                            {{ ucwords($cat->name) }}
                        </td>

                        <td class="text-center">

                            <a href="{{ route('admin.categories.edit', $cat->id) }}"
                               class="btn btn-warning btn-sm rounded-pill px-3">
                                Edit
                            </a>

                            <form action="{{ route('admin.categories.destroy', $cat->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('Delete this category?')"
                                        class="btn btn-danger btn-sm rounded-pill px-3">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="2" class="text-center py-5 text-muted">
                            No Categories Found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-4">
        {{ $categories->links() }}
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
    padding:20px;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
}

.table{
    margin-bottom:0;
}

.table thead{
    background:#f8f9fa;
}

.table thead th{
    padding:16px;
    border:none;
    font-size:15px;
    font-weight:700;
    color:#374151;
}

.table tbody td{
    padding:18px 16px;
    vertical-align:middle;
    border-top:1px solid #eef2f7;
}

.table tbody tr:hover{
    background:#f9fafb;
    transition:.3s;
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

.btn-warning{
    background:#f59e0b;
    color:#fff;
    border:none;
    font-weight:600;
}

.btn-warning:hover{
    background:#d97706;
    color:#fff;
}

.btn-danger{
    font-weight:600;
}

.rounded-pill{
    border-radius:50px !important;
}

</style>

@endsection