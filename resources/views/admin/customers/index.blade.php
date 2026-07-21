@extends('layouts.admin')

@section('content')

<div class="dashboard">

    <div class="welcome mb-4">
        <h2>Customers</h2>
        <p>Manage all registered customers</p>
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
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Total Orders</th>
                    <th>Total Spent</th>
                    <th>Status</th>
                    <th class="text-center" width="180">Action</th>
                </tr>
            </thead>

            <tbody>

            @forelse($customers as $customer)

                <tr>

                    <td class="fw-semibold">
                        {{ $customer->name }}
                    </td>

                    <td>
                        {{ $customer->email }}
                    </td>

                    <td>
                        {{ $customer->phone }}
                    </td>

                    <td>
                        <span class="badge bg-primary">
                            {{ $customer->total_orders }}
                        </span>
                    </td>

                    <td>
                        <strong>
                            Rs. {{ number_format($customer->total_spent,2) }}
                        </strong>
                    </td>

                    <td>

                        @if($customer->status == 'Active')

                            <span class="badge bg-success">
                                Active
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Inactive
                            </span>

                        @endif

                    </td>

                    <td class="text-center">

                        <div class="d-flex gap-2 justify-content-center">

                            <a href="{{ route('admin.customers.show',$customer->id) }}"
                               class="btn btn-primary btn-sm rounded-pill px-3">
                                View
                            </a>

                            <form action="{{ route('admin.customers.destroy',$customer->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Do you want to delete this customer?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3">
                                    Delete
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        No Customers Found
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-4">
        {{ $customers->links() }}
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

.table thead{
    background:#f8f9fa;
}

.table thead th{
    border:none;
    padding:16px;
    color:#374151;
    font-weight:700;
}

.table tbody td{
    padding:18px 16px;
    border-top:1px solid #eef2f7;
}

.table tbody tr:hover{
    background:#f9fafb;
}

.badge{
    padding:8px 12px;
    font-size:12px;
}

.rounded-pill{
    border-radius:50px !important;
}

</style>

@endsection