<x-layouts.app>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                @if (session('status'))
                    <div class="alert alert-primary" role="alert">{{ session('status') }}</div>
                @endif

                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odit at, nulla sunt aut, earum deserunt quo excepturi placeat labore delectus magni, explicabo cumque doloribus dignissimos libero pariatur sequi accusantium repellendus!
            </div>
        </div>
    </div>
</x-layouts.app>
