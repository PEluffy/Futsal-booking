<!-- Our COURTS -->
<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR COURTS</h2>

<div class="container">
    <div class="row">
        @forelse($courts as $court)
        <div class="col-md-4 mb-4">
            <x-court-card :court="$court" class="h-100" />
        </div>
        @empty
        <div class="col-12 mb-4">
            <div class="card h-100 text-center">
                NO data found
            </div>
        </div>
        @endforelse
    </div>
</div>