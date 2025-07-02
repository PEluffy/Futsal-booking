<!-- Facilities -->
<h2 class="mt-5 pt-4 mb-5 text-center fw-bold h-font">OUR FACILITIES</h2>

<div class="container">
    <div class="row justify-content-center g-4">
        @if (empty($facilities) || count($facilities) == 0)
        <div>Nothing to show</div>
        @else
        @foreach ($facilities as $facility)
        <x-facility-card :facility="$facility" />
        @endforeach
        @endif
    </div>
</div>