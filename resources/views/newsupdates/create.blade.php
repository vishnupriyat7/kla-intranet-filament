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
                <h2 class="fw-bold">Add News</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('news-updates.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" placeholder="Enter Date" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter Title" required>
                    </div>
                    <div class="mb-3">
                        <label for="path" class="form-label">Upload File</label>
                        <input type="file" class="form-control" name="path" required>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="1">Published</option>
                            <option value="0">Unpublished</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('news-updates.index') }}" class="btn btn-secondary">Back</a>
                </form>

            </div>
        </div>
    </div>

</x-app-layout>
