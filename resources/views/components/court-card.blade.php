@props(['court'])

<div {{ $attributes->merge(['class' => 'card h-100']) }}>
    <img src="{{ asset('image/courts/' . $court->image) }}"
        class="card-img-top"
        alt="{{ $court->name }}">

    <div class="card-body">
        <h5 class="card-title">{{ $court->name }}</h5>
        <p class="card-text">Price: ${{ $court->price }}</p>
    </div>
    <a href="{{ url('/booking') }}" class="btn btn-outline-primary  mx-2 mb-2">Book</a>
</div>