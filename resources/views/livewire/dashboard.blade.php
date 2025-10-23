<div class="container">
    <div x-data="{ visible: false, timeout: null }" x-init="@this.on('resetSearch', () => {
        clearTimeout(timeout);

        visible = true;
        timeout = setTimeout(() => visible = false, 2500);
    })" x-show="visible" style="display: none;" class="alert alert-secondary" role="alert">
        Search has been reset!
    </div>

    <div class="row justify-content-center">
        <div class="text-center mb-3">
            <button @click="$wire.resetSearch()" class="btn btn-secondary">Reset All Search</button>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Sarch via Alpine.js</div>
                <div class="card-body">
                    <div x-data="{
                        search: '',
                        get filteredNames() {
                            return this.search
                                ? $wire.names.filter(i => i.toLowerCase().includes(this.search.toLowerCase()))
                                : $wire.names;
                        }
                    }"
                    x-init="@this.on('resetSearch', () => search = '')">
                        <input x-model="search" placeholder="Search names..." class="form-control mb-3">

                        <template x-if="filteredNames.length === 0">
                            <p class="text-muted">No results found.</p>
                        </template>

                        <template x-if="filteredNames.length > 0">
                            <ul class="list-group">
                                <template x-for="name in filteredNames" :key="name">
                                    <li class="list-group-item" x-text="name"></li>
                                </template>
                            </ul>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Search via Livewire</div>
                <div class="card-body">
                    <input wire:model.live="search" placeholder="Search names..." class="form-control mb-3">

                    @if (empty($this->filteredNames))
                        <p class="text-muted">No results found.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($this->filteredNames as $name)
                                <li class="list-group-item">{{ $name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
