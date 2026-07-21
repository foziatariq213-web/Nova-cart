@extends('frontend.layouts.app')

@section('content')

<div class="container py-5">

<h2 class="mb-4">
Mood Shop
</h2>

<div class="row">

@foreach($moods as $mood)

<div class="col-md-3 mb-4">

<div class="card shadow text-center p-4">

<h4>{{ $mood->name }}</h4>

<p>
{{ $mood->products_count }}
Products
</p>

<a href="{{ route('moods.show',$mood) }}"
class="btn btn-dark">

Explore

</a>

</div>

</div>

@endforeach

</div>

</div>

@endsection