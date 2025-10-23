<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <a wire:navigate class="navbar-brand" href="/">TAM-RH</a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if (request()->routeIs('dashboard'))
                    <li class="dropdown" x-data="{ open: false }">
                        <button class="btn btn-secondary text-nowrap" type="button" @click="open = ! open">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="dropdown-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                        <ul class="dropdown-menu end-0 mt-1" :class="{ 'd-block': open }">
                            <li><a class="dropdown-item" wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>
                                <form method="POST" action="{{ route('session.destroy') }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" wire:navigate href="{{ route('session.create') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" wire:navigate href="{{ route('register') }}">Register</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
