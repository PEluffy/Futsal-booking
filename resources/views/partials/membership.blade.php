@php
$plans = [
[
'title' => 'Daily Fix Time',
'subtitle' => 'Perfect for consistent ',
'price' => 89,
'tag' => 'Most Popular',
'tag_class' => 'bg-dark',
'icon' => '🕒',
'features' => [
'Same time slot every day',
'Priority booking guarantee',
'No cancellation fees',
'Personal trainer consultation',
'Locker included',
],
'button' => ['text' => 'Choose Plan', 'class' => 'btn-dark']
],
[
'title' => 'Weekdays Only',
'subtitle' => 'Ideal for working professionals',
'price' => 69,
'tag' => 'Best Value',
'tag_class' => 'bg-secondary',
'icon' => '📅',
'features' => [
'Monday to Friday access',
'Flexible time slots',
'Business hours priority',
'Group class access',
'Mobile app booking',
],
'button' => ['text' => 'Get Started', 'class' => 'btn-outline-dark']
],
[
'title' => 'Weekends Only',
'subtitle' => 'Perfect for weekend warriors',
'price' => 49,
'tag' => 'Weekend Special',
'tag_class' => 'bg-info text-dark',
'icon' => '📅',
'features' => [
'Saturday & Sunday access',
'Extended weekend hours',
'Family-friendly sessions',
'Weekend group activities',
'Flexible booking',
],
'button' => ['text' => 'Join Now', 'class' => 'btn-outline-dark']
],
[
'title' => 'Off-Peak Hours',
'subtitle' => 'Great savings ',
'price' => 39,
'tag' => 'Budget Friendly',
'tag_class' => 'bg-success',
'icon' => '🧘',
'features' => [
'11 AM - 1 PM access',
'Quieter gym environment',
'All equipment available',
'Senior discounts available',
'Month-to-month flexibility',
],
'button' => ['text' => 'Save Now', 'class' => 'btn-outline-dark']
],
];
@endphp

<div class="container">
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR MEMBERSHIP</h2>
    <div class="row g-4">
        @foreach ($plans as $plan)
        <div class="col-md-6 col-lg-3">
            <div class="card border shadow-sm text-center h-100">
                <div class="card-body">
                    <div class="badge {{ $plan['tag_class'] }} mb-2">{{ $plan['tag'] }}</div>
                    <div class="mb-3 fs-1">{{ $plan['icon'] }}</div>
                    <h5 class="card-title fw-bold">{{ $plan['title'] }}</h5>
                    <p class="text-muted">{{ $plan['subtitle'] }}</p>
                    <h3 class="fw-bold">${{ $plan['price'] }}<small class="text-muted">/month</small></h3>
                    <ul class="list-unstyled mt-3 mb-4 text-start">
                        @foreach ($plan['features'] as $feature)
                        <li>✔ {{ $feature }}</li>
                        @endforeach
                    </ul>
                    <a href="#" class="btn {{ $plan['button']['class'] }} w-100">{{ $plan['button']['text'] }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>