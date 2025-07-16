@extends('admin.layouts.app')

@section('title', 'Manage Contact Info')

@section('content')


<div class="container mt-4">
    @if(session()->has('warning'))
    <div class="alert alert-warning alert-message">
        {{ session()->get('warning') }}
    </div>
    @endif
    @if(session()->has('success'))
    <div class="alert alert-success alert-message">
        {{ session()->get('success') }}
    </div>
    @endif
    <h2 class="mb-4"> Manage Contact Information</h2>
    <div class="card">
        <div class="card-header bg-black text-white">Update Contact Info</div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.update.contact') }}">
                @csrf

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" name="phone" id="phone" class="form-control"
                        placeholder="+97798XXXXXXXX" value="{{ old('phone', $contact->phone ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="admin@example.com" value="{{ old('email', $contact->email ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="mapSrc" class="form-label">Map Src</label>
                    <input type="text" name="mapSrc" id="mapSrc" class="form-control"
                        placeholder="add an iframe src" value="{{ old('mapSrc', $contact->mapSrc ?? '') }}" required>
                </div>

                <hr>
                <h5 class="mt-4 mb-3"> Social Media Links</h5>

                <div class="mb-3">
                    <label for="facebook" class="form-label">Facebook</label>
                    <input type="url" name="facebook" id="facebook" class="form-control"
                        placeholder="https://facebook.com/yourpage" value="{{ old('facebook', $contact->facebook ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="instagram" class="form-label">Instagram</label>
                    <input type="url" name="instagram" id="instagram" class="form-control"
                        placeholder="https://instagram.com/yourhandle" value="{{ old('instagram', $contact->instagram ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="twitter" class="form-label">Twitter</label>
                    <input type="url" name="twitter" id="twitter" class="form-control"
                        placeholder="https://twitter.com/yourhandle" value="{{ old('twitter', $contact->twitter ?? '') }}">
                </div>

                <button type="submit" class="btn bg-black text-white">Save Contact Info</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    console.log('we are here');
    setTimeout(() => {
        const successMessage = document.querySelector('.alert-message');
        if (successMessage) {
            successMessage.classList.add('fade-out');
        }
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 500);
    }, 3000);
</script>
@endsection