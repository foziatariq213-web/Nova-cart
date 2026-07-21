@extends('layouts.admin')

@section('content')

<div class="dashboard">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div class="welcome">
            <h2>Products</h2>
            <p>Manage all your store products</p>
        </div>

        <a href="{{ route('admin.products.create') }}"
           class="btn btn-primary px-4 py-2 rounded-pill">
            <i class="fa-solid fa-plus me-2"></i>
            Add Product
        </a>

    </div>

    <!-- ===== TOAST MESSAGE - TOP CENTER POSITION ===== -->
    @if(session('success'))
        <div id="toast-message" style="
            position: fixed;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            background: rgba(34, 197, 94, 0.95);
            color: white;
            padding: 16px 35px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            text-align: center;
            min-width: 280px;
            max-width: 90%;
            animation: slideDown 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        ">
            <span style="font-size: 24px;">✅</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="card-custom">

        <table class="table table-hover align-middle mb-0">

            <thead>
                <tr>
                    <th width="75">Image</th>
                    <th width="150">Name</th>
                    <th width="120">Category</th>
                    <th width="110">Brand</th>
                    <th width="110">New Price</th>
                    <th width="110">Old Price</th>
                    <th width="85">Stock</th>
                    
                    <!-- NEW GIFT & MOOD COLUMNS -->
                    <th width="110">😊 Mood</th>
                    <th width="120">🎯 Gift For</th>
                    <th width="130">🎉 Occasion</th>
                    
                    <th width="180">Description</th>
                    <th width="170" class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>

            @forelse($products as $product)

                <tr>

                    <td>
                        @if($product->image)
    <picture>
        <source srcset="{{ asset(preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $product->image)) }}" type="image/webp">
        <img src="{{ asset($product->image) }}"
             width="55"
             height="55"
             style="object-fit:cover;border-radius:8px;">
    </picture>
@else
                            <span class="text-muted" style="font-size:12px;">No Image</span>
                        @endif
                    </td>

                    <td class="fw-semibold" style="font-size:14px;">
                        {{ \Illuminate\Support\Str::limit($product->name, 25) }}
                    </td>

                    <td style="font-size:13px;">
                        {{ \Illuminate\Support\Str::limit($product->category->name ?? 'N/A', 18) }}
                    </td>

                    <td style="font-size:13px;">
                        {{ \Illuminate\Support\Str::limit($product->brand ?? '-', 15) }}
                    </td>

                    <td style="font-size:14px; font-weight:600; color:#2563eb;">
                        Rs. {{ number_format($product->new_price,0) }}
                    </td>

                    <td style="font-size:13px;">
                        @if($product->old_price)
                            <span class="text-decoration-line-through text-muted">
                                Rs. {{ number_format($product->old_price,0) }}
                            </span>
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if($product->stock > 0)
                            <span class="badge bg-success" style="font-size:12px; padding:5px 12px;">
                                {{ $product->stock }}
                            </span>
                        @else
                            <span class="badge bg-danger" style="font-size:12px; padding:5px 12px;">
                                Out
                            </span>
                        @endif
                    </td>

                    <!-- ===== MOOD - SIRF 5 MOODS WITH ICONS ===== -->
                    <td>
                        @if($product->mood)
                            @php
                                $moodIcons = [
                                    'Party' => '🎉',
                                    'Office' => '💼',
                                    'Casual' => '👕',
                                    'Self Care' => '🧘',
                                    'Wedding' => '💒',
                                ];
                                
                                $moodColors = [
                                    'Party' => '#8B5CF6',
                                    'Office' => '#3B82F6',
                                    'Casual' => '#10B981',
                                    'Self Care' => '#EC4899',
                                    'Wedding' => '#F59E0B',
                                ];
                            @endphp
                            <span class="badge" style="background-color: {{ $moodColors[$product->mood->name] ?? '#6c757d' }}; color: white; padding: 5px 12px; font-size:12px;">
                                {{ $moodIcons[$product->mood->name] ?? '😊' }} {{ \Illuminate\Support\Str::limit($product->mood->name, 10) }}
                            </span>
                        @else
                            <span class="text-muted" style="font-size:12px;">-</span>
                        @endif
                    </td>

                    <!-- Gift For -->
                    <td>
                        @if($product->gift_for)
                            <span class="badge bg-info" style="padding: 5px 12px; font-size:12px;">
                                @php
                                    $giftEmojis = [
                                        'Mother' => '👩',
                                        'Father' => '👨',
                                        'Brother' => '👦',
                                        'Sister' => '👧',
                                        'Friend' => '👫',
                                        'Husband' => '💑',
                                        'Wife' => '💑',
                                        'Son' => '👦',
                                        'Daughter' => '👧',
                                        'Grandmother' => '👵',
                                        'Grandfather' => '👴'
                                    ];
                                @endphp
                                {{ $giftEmojis[$product->gift_for] ?? '🎯' }} {{ \Illuminate\Support\Str::limit($product->gift_for, 10) }}
                            </span>
                        @else
                            <span class="text-muted" style="font-size:12px;">-</span>
                        @endif
                    </td>

                    <!-- Occasion -->
                    <td>
                        @if($product->occasion)
                            <span class="badge bg-warning text-dark" style="padding: 5px 12px; font-size:12px;">
                                @php
                                    $occasionEmojis = [
                                        'Party' => '🥳',
                                        'Office' => '💼',
                                        'Casual' => '👕',
                                        'Self Care' => '🧴',
                                        'Wedding' => '💍',
                                    ];
                                @endphp
                                {{ $occasionEmojis[$product->occasion] ?? '🎉' }} {{ \Illuminate\Support\Str::limit($product->occasion, 10) }}
                            </span>
                        @else
                            <span class="text-muted" style="font-size:12px;">-</span>
                        @endif
                    </td>

                    <!-- Description -->
                    <td style="font-size:13px; max-width:180px;">
                        {{ \Illuminate\Support\Str::limit($product->description ?? '-', 40) }}
                    </td>

                    <!-- Actions -->
                    <td class="text-center" style="white-space:nowrap;">

                        <a href="{{ route('admin.products.edit',$product->id) }}"
                           class="btn btn-warning btn-sm rounded-pill px-3" style="font-size:13px; padding:5px 14px;">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>

                        <form action="{{ route('admin.products.destroy',$product->id) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('Delete this product?')"
                                    class="btn btn-danger btn-sm rounded-pill px-3" style="font-size:13px; padding:5px 14px;">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="12" class="text-center py-5 text-muted">
                        No Products Found
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>

</div>

<!-- ===== TOAST MESSAGE STYLES & AUTO-HIDE SCRIPT ===== -->
<style>
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    }

    @keyframes slideUp {
        from {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        to {
            opacity: 0;
            transform: translateX(-50%) translateY(-30px);
        }
    }

    #toast-message {
        animation: slideDown 0.5s ease forwards;
    }

    #toast-message.hide {
        animation: slideUp 0.5s ease forwards;
    }

    .table td {
        vertical-align: middle !important;
        padding: 10px 12px !important;
    }

    .table th {
        padding: 12px 12px !important;
        font-size: 13px !important;
        white-space: nowrap !important;
    }

    .table tbody tr {
        height: 62px;
    }

    .table tbody tr:hover {
        background: #f8fafc;
        transition: 0.2s;
    }

    .card-custom {
        padding: 18px !important;
    }

    .badge {
        font-weight: 500 !important;
    }

    .btn-sm {
        padding: 5px 14px !important;
        font-size: 13px !important;
    }

    .btn-sm i {
        font-size: 13px;
        margin-right: 4px;
    }

    .table td:nth-child(11) {
        max-width: 180px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .table {
        min-width: 1200px !important;
        font-size: 13px !important;
    }

    .table tbody td {
        padding: 8px 12px !important;
        font-size: 13px !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('toast-message');
        
        if (toast) {
            setTimeout(function() {
                toast.classList.add('hide');
                
                setTimeout(function() {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 500);
            }, 3000);
        }
    });
</script>

<style>

.dashboard{
    padding: 18px 22px;
}

.welcome h2{
    margin:0;
    font-size:30px;
    font-weight:700;
    color:#111827;
}

.welcome p{
    margin-top:4px;
    color:#6b7280;
    font-size:15px;
}

.card-custom{
    background:#fff;
    border-radius:14px;
    padding:18px 18px 8px 18px !important;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
    overflow-x: auto;
}

.table{
    margin-bottom:0;
    min-width: 1200px;
    font-size:13px;
}

.table thead{
    background:#f8fafc;
    border-radius:8px;
}

.table thead th{
    padding:12px 12px;
    border:none;
    font-size:13px;
    font-weight:700;
    color:#374151;
    white-space: nowrap;
    text-transform:uppercase;
    letter-spacing:0.3px;
}

.table tbody td{
    padding:8px 12px;
    vertical-align:middle;
    border-top:1px solid #eef2f7;
    font-size:13px;
}

.table tbody tr{
    height:58px;
}

.table tbody tr:hover{
    background:#f9fafb;
    transition:.2s;
}

.table img{
    border-radius:8px;
    border:1px solid #eef2f7;
    width:50px;
    height:50px;
    object-fit:cover;
}

.btn-primary{
    background:#2563eb;
    border:none;
    font-weight:600;
    font-size:14px;
    padding:10px 24px;
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
    font-weight:500;
}

.btn-warning:hover{
    background:#d97706;
    color:#fff;
}

.btn-danger{
    font-weight:500;
}

.badge{
    padding:5px 12px;
    font-size:12px;
    font-weight:500;
    border-radius:6px;
}

.rounded-pill{
    border-radius:50px !important;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .dashboard {
        padding: 10px;
    }
    
    .table {
        font-size: 12px;
        min-width: 1100px;
    }
    
    .table thead th,
    .table tbody td {
        padding: 6px 8px !important;
    }
    
    #toast-message {
        top: 15px !important;
        padding: 12px 20px !important;
        font-size: 14px !important;
        min-width: 200px !important;
    }

    .welcome h2 {
        font-size: 22px;
    }

    .btn-primary {
        font-size: 12px;
        padding: 6px 16px;
    }
}

</style>

@endsection