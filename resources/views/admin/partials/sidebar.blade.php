<div class="bg-dark text-white p-3" style="width: 250px; height: 100vh;">
    <h4 class="text-center">Admin Panel
        @php
        use Illuminate\Support\Facades\Auth;
        @endphp

        @if (Auth::guard('admin')->check())
        @php
        $email = Auth::guard('admin')->user()->email;
        $username = explode('@', $email)[0];
        @endphp
        Welcome {{ $username }}
        @endif

    </h4>
    <ul class="nav flex-column mt-4">
        <li class="nav-item mb-2">
            <a href="{{ route('admin.courts') }}" class="nav-link text-white">🏟️ Courts</a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.show.contact') }}" class="nav-link text-white">📞 Contact Info</a>
        </li>
        <li class="nav-item mt-4">
            <form method="POST" action={{ route('admin.logout') }}>
                @csrf
                <button class="btn btn-sm btn-danger w-100">Logout</button>
            </form>
        </li>
    </ul>
</div>