@extends('admin.layouts.app')

@section('title', 'Manage Courts')

@section('content')
<div class="container mt-4">

    <!-- Courts comming from the view  -->
    @if ($courts->isEmpty())
    <div class="alert alert-warning">No courts added yet.</div>
    @else
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>type</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courts as $court)
            <tr>
                <td>{{ $court->name }}</td>
                <td>{{ $court->type }}</td>
                <td>Rs. {{ $court->price }}</td>
                <td> <img src={{ asset('image/courts/' . $court->image) }} alt="Current Court Image" style="max-width:40px; max-height:40px; object-fit: contain;"> {{ $court->image }}</td>

                <td>
                    <!-- Button trigger modal -->

                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop"
                        data-id="{{ $court->id }}"
                        data-name="{{ $court->name }}"
                        data-type="{{ $court->type }}"
                        data-price="{{ $court->price }}"
                        data-facilities='@json($court->facilities->pluck("id"))'
                        data-image="{{ asset('image/courts/' . $court->image) }}">
                        Edit
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editCourtForm" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="court-name" class="form-label">Court Name</label>
                                            <input type="text" name="name" id="court-name" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="court-type" class="form-label">Type</label>
                                            <select name="type" id="court-type" class="form-select" required>
                                                @foreach (App\Enums\CourtType::cases() as $type)
                                                <option value="{{ $type->value }}">{{ $type->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="court-price" class="form-label">Price</label>
                                            <input type="text" name="price" id="court-price" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Facilities</label><br>
                                            @foreach ($facilities as $facility)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input edit-facility-checkbox" type="checkbox" name="facilities[]" value="{{ $facility->id }}" id="facility-{{ $facility->id }}">
                                                <label class="form-check-label" for="facility-{{ $facility->id }}">{{ $facility->name }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="mb-3">
                                            <label for="court-image" class="form-label">Change Image (optional)</label>
                                            <input type="file" name="image" id="court-image" class="form-control" accept="image/*">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Current Image</label>
                                            <div>
                                                <img src="" id="court-current-image" alt="Current Court Image" style="max-width: 50%; max-height: 100px; object-fit: contain;">
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this court?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    <h2 class="mb-4">Add Courts</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header bg-black text-white">Add New Court</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.create.court') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Court Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    @php
                    use App\Enums\CourtType;
                    @endphp
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="">-- Select Type --</option>
                        @foreach (CourtType::cases() as $type)
                        <option value="{{ $type->value }}">{{ $type->value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" name="price" id="price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Facilities</label>
                    <div>
                        @foreach ($facilities as $facility)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $facility->id }}" id="facility-{{ $facility->id }}">
                            <label class="form-check-label" for="facility-{{ $facility->id }}">{{ $facility->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image">Choose a picture:</label>
                    <input type="file" id="image" name="image" accept="image/png, image/jpeg" class="form-control" required />
                </div>
                <button type="submit" class="btn bg-black text-white">Add Court</button>
            </form>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('staticBackdrop');
        modal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;

            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const type = button.getAttribute('data-type');
            const price = button.getAttribute('data-price');
            const facilities = JSON.parse(button.getAttribute('data-facilities'));
            const imageUrl = button.getAttribute('data-image');


            console.log({
                id,
                name,
                type,
                price,
                facilities
            });

            // Fill modal fields
            document.getElementById('court-name').value = name;
            document.getElementById('court-type').value = type;
            document.getElementById('court-price').value = price;

            // Check the facilities checkboxes that belong to this court
            document.querySelectorAll('.edit-facility-checkbox').forEach(checkbox => {
                checkbox.checked = facilities.includes(parseInt(checkbox.value));
            });
            document.getElementById('court-current-image').src = imageUrl;

            // Update form action URL dynamically for the court being edited
            const form = document.getElementById('editCourtForm');
            form.action = `/admin/courts/${id}`; // adapt to your route
        });
    });
</script>
@endsection