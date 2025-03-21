@auth
    <header>
        <nav class="container">
            <div class="btn-group btn-group--right">
                <p>{{ auth()->user()->email }}</p>
                <a class="btn btn--primary btn--small" href="{{ route('profile') }}">Profile</a>
            </div>
        </nav>
    </header>
@endauth
