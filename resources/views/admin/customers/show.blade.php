@extends('layouts.admin')

@section('content')

<div class="dashboard">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div class="welcome">
            <h2>Customer Details</h2>
            <p>View customer information</p>
        </div>

        <a href="{{ route('admin.customers.index') }}"
           class="btn btn-secondary rounded-pill px-4">
            ← Back
        </a>

    </div>

    <div class="card-custom">

        <div class="row">

            <div class="col-md-6">

                <table class="table table-borderless">

                    <tr>
                        <th width="170">Customer Name</th>
                        <td>{{ $customer->name }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $customer->email }}</td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td>{{ $customer->phone }}</td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td>{{ $customer->address }}</td>
                    </tr>

                </table>

            </div>

            <div class="col-md-6">

                <table class="table table-borderless">

                    <tr>
                        <th width="170">Total Orders</th>
                        <td>{{ $customer->total_orders }}</td>
                    </tr>

                    <tr>
                        <th>Total Spent</th>
                        <td>
                            <strong>
                                Rs. {{ number_format($customer->total_spent,2) }}
                            </strong>
                        </td>
                    </tr>

                    <tr>
                        <th>Status</th>
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
                    </tr>

                    <tr>
                        <th>Joined</th>
                        <td>{{ $customer->created_at->format('d M Y') }}</td>
                    </tr>

                </table>

            </div>

        </div>

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
    color:#6b7280;
    margin-top:5px;
}

.card-custom{
    background:#fff;
    border-radius:16px;
    padding:25px;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
}

.table th{
    color:#374151;
    width:170px;
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