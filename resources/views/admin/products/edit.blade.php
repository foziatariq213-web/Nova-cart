@extends('layouts.admin')

@section('content')

<div class="container">

    <h2 class="mb-4">Edit Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- ===== BASIC INFORMATION ===== -->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Name *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Category</label>
                    <input type="text"
                           name="category"
                           value="{{ old('category', $product->category->name ?? '') }}"
                           class="form-control"
                           placeholder="e.g. Electronics">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Brand</label>
                    <input type="text"
                           name="brand"
                           value="{{ old('brand', $product->brand ?? '') }}"
                           class="form-control"
                           placeholder="e.g. Apple">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label>New Price *</label>
                    <input type="number"
                           step="0.01"
                           name="new_price"
                           value="{{ old('new_price', $product->new_price) }}"
                           class="form-control"
                           required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label>Old Price</label>
                    <input type="number"
                           step="0.01"
                           name="old_price"
                           value="{{ old('old_price', $product->old_price ?? '') }}"
                           class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label>Stock</label>
                    <input type="number"
                           name="stock"
                           value="{{ old('stock', $product->stock) }}"
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Current Image</label><br>
                    @if($product->image)
    <picture>
        <source srcset="{{ asset(preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $product->image)) }}" type="image/webp">
        <img src="{{ asset($product->image) }}"
             style="width:100px;height:100px;object-fit:cover;border-radius:8px;"
             class="mb-2">
    </picture>
@else
                        <p class="text-muted">No image uploaded</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label>Change Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
        </div>

        <!-- ===== GIFT & MOOD SECTION ===== -->
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">🎁 Gift & Mood Settings</h5>
            </div>
            <div class="card-body">

                <!-- Mood -->
                <div class="mb-3">
                    <label>😊 Mood</label>
                    <select name="mood_id" class="form-control">
                        <option value="">Select Mood</option>

                        <option value="1" {{ old('mood_id', $product->mood_id) == 1 ? 'selected' : '' }}>
                            🎉 Party
                        </option>
                        <option value="2" {{ old('mood_id', $product->mood_id) == 2 ? 'selected' : '' }}>
                            💼 Office
                        </option>
                        <option value="3" {{ old('mood_id', $product->mood_id) == 3 ? 'selected' : '' }}>
                            👕 Casual
                        </option>
                        <option value="4" {{ old('mood_id', $product->mood_id) == 4 ? 'selected' : '' }}>
                            🧘 Self Care
                        </option>
                        <option value="5" {{ old('mood_id', $product->mood_id) == 5 ? 'selected' : '' }}>
                            💒 Wedding
                        </option>

                    </select>
                </div>

                <!-- ===== GIFT FOR - SIRF 6 OPTIONS ===== -->
                <div class="mb-3">
                    <label>🎯 Gift For</label>
                    <select name="gift_for" class="form-control">
                        <option value="">Select Receiver</option>
                        <option value="Mother" {{ old('gift_for', $product->gift_for) == 'Mother' ? 'selected' : '' }}>👩 Mother</option>
                        <option value="Father" {{ old('gift_for', $product->gift_for) == 'Father' ? 'selected' : '' }}>👨 Father</option>
                        <option value="Brother" {{ old('gift_for', $product->gift_for) == 'Brother' ? 'selected' : '' }}>👦 Brother</option>
                        <option value="Sister" {{ old('gift_for', $product->gift_for) == 'Sister' ? 'selected' : '' }}>👧 Sister</option>
                        <option value="Husband" {{ old('gift_for', $product->gift_for) == 'Husband' ? 'selected' : '' }}>💑 Husband</option>
                        <option value="Wife" {{ old('gift_for', $product->gift_for) == 'Wife' ? 'selected' : '' }}>💑 Wife</option>
                        <option value="Friend" {{ old('gift_for', $product->gift_for) == 'Friend' ? 'selected' : '' }}>👫 Friend</option>
                    </select>
                </div>

                <!-- Occasion -->
                <div class="mb-3">
                    <label>🎉 Occasion</label>
                    <select name="occasion" class="form-control">
                        <option value="">Select Occasion</option>

                        <option value="Birthday" {{ old('occasion', $product->occasion) == 'Birthday' ? 'selected' : '' }}>
                            🎂 Birthday
                        </option>
                        <option value="Anniversary" {{ old('occasion', $product->occasion) == 'Anniversary' ? 'selected' : '' }}>
                            💍 Anniversary
                        </option>
                        <option value="Eid" {{ old('occasion', $product->occasion) == 'Eid' ? 'selected' : '' }}>
                            🕌 Eid
                        </option>
                        <option value="Graduation" {{ old('occasion', $product->occasion) == 'Graduation' ? 'selected' : '' }}>
                            🎓 Graduation
                        </option>
                        <option value="Wedding" {{ old('occasion', $product->occasion) == 'Wedding' ? 'selected' : '' }}>
                            💒 Wedding
                        </option>

                    </select>
                </div>

            </div>
        </div>

        <!-- ===== SUBMIT BUTTON ===== -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>

    </form>

</div>

@endsection