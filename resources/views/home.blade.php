<x-layouts.app>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                @if (session('status'))
                    <div class="alert alert-primary" role="alert">{{ session('status') }}</div>
                @endif

                asdf
            </div>
        </div>
    </div>
</x-layouts.app>
