@extends('layouts.admin')

@section('content')

<div class="dashboard">

    <div class="welcome mb-4">
        <h2>Orders</h2>
        <p>Manage all customer orders</p>
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
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                    <th>Date</th>
                    <th class="text-center" width="120">Action</th>
                </tr>
            </thead>

            <tbody>

            @forelse($orders as $order)

                <tr>

                    <td class="fw-bold">
                        {{ $order->order_number }}
                    </td>

                    <td>
                        <div class="fw-semibold">
                            {{ $order->customer_name }}
                        </div>

                        <small class="text-muted">
                            {{ $order->email }}
                        </small>
                    </td>

                    <td>
                        <strong>
                            Rs. {{ number_format($order->total,2) }}
                        </strong>
                    </td>

                    <!-- Payment Method -->
                    <td>
                        {{ $order->payment_method }}
                    </td>

                    <!-- Payment Status -->
                    <td>
                        @if($order->payment_status == 'Paid')
                            <span class="badge bg-success">
                                Paid
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Unpaid
                            </span>
                        @endif
                    </td>

                    <!-- Order Status -->
                    <td>

                        @if($order->order_status == 'Pending')
                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>

                        @elseif($order->order_status == 'Processing')
                            <span class="badge bg-primary">
                                Processing
                            </span>

                        @elseif($order->order_status == 'Shipped')
                            <span class="badge bg-info">
                                Shipped
                            </span>

                        @elseif($order->order_status == 'Delivered')
                            <span class="badge bg-success">
                                Delivered
                            </span>

                        @else
                            <span class="badge bg-danger">
                                Cancelled
                            </span>
                        @endif

                    </td>

                    <td>
                        {{ $order->created_at->format('d M Y') }}
                    </td>

                    <td class="text-center" style="white-space:nowrap;">

                        <a href="{{ route('admin.orders.show', $order->id) }}"
                           class="btn btn-primary btn-sm rounded-pill px-3">
                            View
                        </a>

                        <form action="{{ route('admin.orders.destroy', $order->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this order? This cannot be undone.');">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm rounded-pill px-3">
                                Delete
                            </button>
                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        No Orders Found
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-4">
        {{ $orders->links() }}
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