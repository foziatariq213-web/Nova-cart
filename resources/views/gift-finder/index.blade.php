@extends('frontend.layouts.app')

@section('content')

<div class="container py-5">

<h2>

Gift Finder

</h2>

<form action="{{ route('gift.results') }}"
method="POST">

@csrf

<div class="mb-3">

<label>

Select Gift Category

</label>

<select
name="gift_category_id"
class="form-control">

@foreach($giftCategories as $gift)

<option
value="{{ $gift->id }}">

{{ $gift->receiver }}

-
{{ $gift->occasion }}

</option>

@endforeach

</select>

</div>

<button
class="btn btn-success">

Find Gifts

</button>

</form>

</div>

@endsection