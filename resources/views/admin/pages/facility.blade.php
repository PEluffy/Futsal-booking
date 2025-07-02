@extends('admin.layouts.app')

@section('title', 'Add New Facility')

@section('content')
<div class="container mt-4">

    <h1>
        Facilities
    </h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5 facilities-show">
        @foreach ($facilities as $facility)
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-start gap-3">
                    <div>
                        <h5 class="card-title mb-1">{{ $facility->name }}</h5>
                        <p class="card-text text-muted small">{{ $facility->desc }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <h2>Add New Facility</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- action="{{ route('admin.create.facility') }}" -->
    <form class="form">
        @csrf
        <div class="mb-3">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <label for="name" class="form-label">Facility Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter facility name">
            <label for="icon" class="form-label">Icon Svg</label>
            <input type="text" class="form-control" id="icon" name="icon" placeholder="plz provide svg" />
            <label for="desc" class="form-label">Facility Name</label>
            <input type="text" class="form-control" id="desc" name="desc" placeholder="Enter description">
        </div>
        <button type="submit" class="btn btn-primary">Add Facility</button>
    </form>
    <p class="err"></p>
    <p class="suc"></p>
</div>
@endsection
@section('scripts')
<script>
    console.log(document.querySelector('meta[name="csrf-token"]').content);
    const facility_div = document.querySelector('.facilities-show')

    const form = document.querySelector('.form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const name = document.querySelector('#name').value;
        const icon = document.querySelector('#icon').value;
        const desc = document.querySelector('#desc').value;
        console.log(name, icon);
        try {
            const res = await fetch('/admin/facility', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    name: name,
                    icon: icon,
                    desc: desc
                }),
            });
            const data = await res.json();
            const col = document.createElement('div');
            col.className = 'col';

            col.innerHTML = `
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-start gap-3">  
                    <div>
                        <h5 class="card-title mb-1">${data.facility.name}</h5>
                        <p class="card-text text-muted small">${data.facility.desc}</p>
                    </div>
                </div>
            </div>
        `;

            facility_div.appendChild(col);
            document.querySelector('.suc').textContent = "sussessfull inserted  a facilities"
        } catch (err) {
            document.querySelector('.err').textContent = "Error while submitting the data try again"
            console.log(err);
        }
    });
</script>


@endsection