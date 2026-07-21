@extends('layouts.admin')

@section('content')

<div class="dashboard">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div class="welcome">
            <h2>Order Details</h2>
            <p>View customer order information</p>
        </div>

        <a href="{{ route('admin.orders.index') }}"
           class="btn btn-secondary rounded-pill px-4">
            ← Back
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">

        <!-- Customer Details -->
        <div class="col-md-6 mb-4">

            <div class="card-custom">

                <h4 class="mb-3">Customer Information</h4>

                <table class="table table-borderless">

                    <tr>
                        <th width="160">Name</th>
                        <td>{{ $order->customer_name }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $order->email }}</td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td>{{ $order->phone }}</td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td>{{ $order->address }}</td>
                    </tr>

                </table>

            </div>

        </div>

        <!-- Order Details -->
        <div class="col-md-6 mb-4">

            <div class="card-custom">

                <h4 class="mb-3">Order Information</h4>

                <table class="table table-borderless">

                    <tr>
                        <th width="160">Order ID</th>
                        <td>{{ $order->order_number }}</td>
                    </tr>

                    <tr>
                        <th>Total</th>
                        <td><strong>Rs. {{ number_format($order->total,2) }}</strong></td>
                    </tr>

                    <tr>
                        <th>Payment Method</th>
                        <td>{{ $order->payment_method }}</td>
                    </tr>

                    <tr>
                        <th>Date</th>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

    <!-- Status Update -->

    <div class="card-custom">

        <h4 class="mb-4">Update Order Status</h4>

        <form action="{{ route('admin.orders.update',$order->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6">

                    <label class="form-label">Order Status</label>

                    <select name="order_status" class="form-select">

                        <option {{ $order->order_status=='Pending' ? 'selected':'' }}>Pending</option>
                        <option {{ $order->order_status=='Processing' ? 'selected':'' }}>Processing</option>
                        <option {{ $order->order_status=='Shipped' ? 'selected':'' }}>Shipped</option>
                        <option {{ $order->order_status=='Delivered' ? 'selected':'' }}>Delivered</option>
                        <option {{ $order->order_status=='Cancelled' ? 'selected':'' }}>Cancelled</option>

                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Payment Status</label>

                    <select name="payment_status" class="form-select">

                        <option {{ $order->payment_status=='Paid' ? 'selected':'' }}>Paid</option>
                        <option {{ $order->payment_status=='Unpaid' ? 'selected':'' }}>Unpaid</option>

                    </select>

                </div>

            </div>

            <button class="btn btn-primary rounded-pill px-4 mt-4">
                Save Changes
            </button>

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
}

.welcome p{
    color:#6b7280;
}

.card-custom{
    background:#fff;
    padding:25px;
    border-radius:16px;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
    margin-bottom:25px;
}

.table th{
    color:#374151;
    width:160px;
}

.form-select{
    height:50px;
    border-radius:10px;
}

.rounded-pill{
    border-radius:50px !important;
}

</style>

@endsection