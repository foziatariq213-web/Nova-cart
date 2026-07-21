@extends('layouts.app')

@section('content')

<style>
.about-bg{
  background:#0d0e12;
  min-height:100vh;
}

/* card */
.about-card{
  background:#141518;
  border:1px solid rgba(255,255,255,.06);
  border-radius:1.5rem;
  transition:.3s;
}
.about-card:hover{
  transform:translateY(-6px);
  border-color:rgba(99,102,241,.3);
  box-shadow:0 0 35px rgba(99,102,241,.15);
}

/* section spacing */
.section{
  padding:5rem 0;
}
</style>

<div class="about-bg">

{{-- HERO --}}
<section class="section text-center">
  <div class="max-w-4xl mx-auto px-6">
    <h1 class="text-5xl font-black text-white">About NovaCart</h1>
    <p class="text-gray-500 mt-4 text-lg">
      A next-generation luxury eCommerce experience built for modern shopping.
    </p>
  </div>
</section>

{{-- STORY --}}
<section class="section">
  <div class="max-w-7xl mx-auto px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center">

    <div class="about-card p-8">
      <h2 class="text-3xl font-black text-white">Our Story</h2>
      <p class="text-gray-400 mt-4 leading-relaxed">
        NovaCart started with a simple idea — make online shopping feel premium,
        fast, and effortless. We combine modern UI, trusted sellers, and curated
        products to deliver a world-class experience.
      </p>

      <p class="text-gray-400 mt-4 leading-relaxed">
        Today, we serve thousands of customers with a focus on quality, trust,
        and design excellence.
      </p>
    </div>

    <div>
      <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=1000&q=80"
           class="rounded-2xl w-full object-cover border border-white/10">
    </div>

  </div>
</section>

{{-- STATS --}}
<section class="section">
  <div class="max-w-7xl mx-auto px-6 lg:px-8 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

    @foreach([
      ['100K+','Orders Delivered'],
      ['50K+','Happy Customers'],
      ['4.9★','Rating'],
      ['24/7','Support']
    ] as $s)

    <div class="about-card p-6 text-center">
      <h3 class="text-3xl font-black text-indigo-400">{{ $s[0] }}</h3>
      <p class="text-gray-500 mt-2">{{ $s[1] }}</p>
    </div>

    @endforeach

  </div>
</section>

{{-- TEAM --}}
<section class="section">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">

    <h2 class="text-4xl font-black text-white text-center mb-12">
      Meet Our <span class="text-indigo-400">Team</span>
    </h2>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

      @foreach([
        ['name'=>'Ali Khan','role'=>'CEO','img'=>'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80'],
        ['name'=>'Sara Ahmed','role'=>'UI/UX Designer','img'=>'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=600&q=80'],
        ['name'=>'Hamza Ali','role'=>'Developer','img'=>'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=600&q=80'],
      ] as $t)

      <div class="about-card overflow-hidden">
        <img src="{{ $t['img'] }}" class="w-full h-60 object-cover">
        <div class="p-5 text-center">
          <h3 class="text-white font-bold text-lg">{{ $t['name'] }}</h3>
          <p class="text-gray-500 text-sm">{{ $t['role'] }}</p>
        </div>
      </div>

      @endforeach

    </div>
  </div>
</section>

</div>

@endsection