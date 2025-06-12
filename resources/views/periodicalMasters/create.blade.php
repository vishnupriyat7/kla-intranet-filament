<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-10">
        {{-- include card here --}}
        <div class="card">
            <div class="card-header p-3">
                <h2 class="fw-bold">Periodical Items</h2>
            </div>
            <div class="card-body">

                <form action="{{ route('periodical-masters.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter periodical name" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="img" class="form-label">Upload File </label>
                        <input type="file" class="form-control" id="img" name="img" required>
                        @error('img')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('periodical-masters.index') }}" class="btn btn-secondary">Back</a>
                </form>

            </div>
        </div>
    </div>

</x-app-layout>
