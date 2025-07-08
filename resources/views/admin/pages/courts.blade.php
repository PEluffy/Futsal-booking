@extends('admin.layouts.app')

@section('title', 'Manage Courts')

@section('content')
<div class="container mt-4">
    <!-- Courts comming from the view  -->
    @if(session()->has('success'))
    <div class="alert alert-success successMessage">
        {{ session()->get('success') }}
    </div>
    @endif


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
            <tr data-court-id="{{ $court->id }}">
                <td class="court-name">{{ $court->name }}</td>
                <td class="court-type">{{ $court->type }}</td>
                <td class="court-price">Rs. {{ $court->price }}</td>
                <td> <img class="court-image" src={{ asset('image/courts/' . $court->image) }} alt="Current Court Image" style="max-width:40px; max-height:40px; object-fit: contain;"></td>

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
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                    <button type="button" class="btn btn-primary update-court">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="POST" style="display:inline;" action={{ route('admin.court.delete',$court->id) }}>
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
    document.querySelector('.update-court').addEventListener('click', async () => {
        const form = document.getElementById('editCourtForm');
        const formData = new FormData(form);
        const courtId = form.getAttribute('data-id');
        for (const [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }
        console.log(courtId);
        const editModal = document.querySelector('#staticBackdrop');
        const modalInstance = bootstrap.Modal.getInstance(editModal);
        modalInstance.hide();
        const res = await fetch(`/admin/court/update/${courtId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData,
        });
        const data = await res.json();
        const row = document.querySelector(`tr[data-court-id="${data.court.id}"]`);
        console.log(row);

        if (row) {
            const courtName = document.querySelector('.court-name');
            const courtType = document.querySelector('.court-type');
            const courtPrice = document.querySelector('.court-price');
            const courtImage = document.querySelector('.court-image');
            courtName.textContent = data.court.name;
            courtType.textContent = data.court.type;
            courtPrice.textContent = `Rs. ${data.court.price}`;
            courtImage.src = `/image/courts/${data.court.image}`;
            courtImage.alt = data.court.name;


        }

        // if (row) {
        //     console.log('we are inside row');
        //     row.querySelector('.court-name').textContent = court.name;
        //     row.querySelector('.court-type').textContent = court.type;
        //     row.querySelector('.court-price').textContent = `Rs. ${court.price}`;
        //     const img = row.querySelector('.court-image img');
        //     img.src = `/image/courts/${court.image}`;
        //     img.alt = court.name;
        //     // Optionally update the image file name text if you want
        //     row.querySelector('.court-image').lastChild.textContent = ` ${court.image}`;

        //     // Also update the Edit button's data attributes so that next time you open modal, it has latest data
        //     const editBtn = row.querySelector('button.btn-primary[data-bs-toggle="modal"]');
        //     if (editBtn) {
        //         editBtn.setAttribute('data-name', court.name);
        //         editBtn.setAttribute('data-type', court.type);
        //         editBtn.setAttribute('data-price', court.price);
        //         editBtn.setAttribute('data-image', `/image/courts/${court.image}`);

        //         // For facilities, you can send IDs as JSON string
        //         const facilityIds = court.facilities.map(f => f.id);
        //         editBtn.setAttribute('data-facilities', JSON.stringify(facilityIds));
        //     }
        // }

    })

    const modal = document.getElementById('staticBackdrop');
    modal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const type = button.getAttribute('data-type');
        const price = button.getAttribute('data-price');
        const facilities = JSON.parse(button.getAttribute('data-facilities'));
        const imageUrl = button.getAttribute('data-image');
        const form = document.getElementById('editCourtForm');
        form.setAttribute('data-id', id);

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
        document.getElementById('court-price').value = price;
    });

    setTimeout(() => {
        const successMessage = document.querySelector('.successMessage');
        if (successMessage) {
            successMessage.classList.add('fade-out');
        }
        setTimeout(() => {
            document.querySelector('.successMessage').style.display = 'none';
        }, 500);
    }, 3000);
    // setTimeout(() => {
    //     document.querySelector('.successMessage').style.display = 'none';
    // }, 3000);
</script>
@endsection