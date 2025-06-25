<!-- Testimonial -->
<section class="mt-5 pt-4">
    <h2 class="text-center fw-bold h-font mb-3">What Our Customers Say</h2>
    <p class="text-center mb-5 text-muted">Real feedback from our happy players and guests.</p>

    <div class="container">
        <div class="swiper swiper-testimonials">
            <div class="swiper-wrapper">
                @foreach ([1,2,3,4,5,6] as $user)
                <div class="swiper-slide bg-white rounded shadow-sm p-4 border">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="{{ asset('image/svg/love.svg') }}" width="30" class="me-2" alt="User {{ $user }}">
                        <h6 class="m-0">Random User {{ $user }}</h6>
                    </div>
                    <p class="text-muted">
                        I had a great experience! The booking was smooth, facilities were clean, and staff were very welcoming.
                    </p>
                    <div class="rating">
                        @for ($i = 0; $i < 4; $i++)
                            <i class="bi bi-star-fill text-warning"></i>
                            @endfor
                    </div>
                </div>
                @endforeach
            </div>

            <div class="swiper-pagination mt-3"></div>
        </div>
    </div>
</section>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
    const testimonialSwiper = new Swiper(".swiper-testimonials", {
        slidesPerView: 3,
        spaceBetween: 20,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            }
        }
    });
</script>