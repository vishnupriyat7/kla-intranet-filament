<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container py-10">
        <div class="card">
            <div class="card-header p-3">
                <h1 class="fw-bold">Edit Periodical List</h1>
            </div>
            <div class="card-body">

                <form action="{{ route('periodical-masters.update', $periodicalMaster->id) }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PATCH') <!-- Specify PATCH method explicitly -->

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $periodicalMaster->name }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="img">Choose Image</label>
                                <input type="file" class="form-control" id="img" name="img">

                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">

                                @if ($periodicalMaster->img)
                                    <p>Current Image: <img src="{{ asset('storage/' . $periodicalMaster->img) }}"
                                            alt="Image" width="100"></p>
                                    {{-- <p><strong>File Path:</strong> {{ asset('storage/' . $periodicalMaster->img) }}</p> --}}
                                @else
                                    N/A
                                @endif
                            </div>

                        </div>


                    </div>


                    <button type="submit" class="btn btn-primary">Update Periodical</button>
                    <a href="{{ route('periodical-masters.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
