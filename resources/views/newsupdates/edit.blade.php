<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container py-10">
        <div class="card">
            <div class="card-header p-3">
                <h1 class="fw-bold">Edit News</h1>
            </div>
            <div class="card-body">



                <form action="{{ route('news-updates.update', $newsupdate->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') <!-- Specify PATCH method explicitly -->

                    <div class="form-group">
                        <label for="name">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $newsupdate->title }}">
                    </div>
                    <div class="form-group">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" value="{{ $newsupdate->date }}">
                    </div>
                    <div class="form-group">
                        <label for="path">Path</label>
                        <input type="file" class="form-control" id="path" name="path"
                            value="{{ $newsupdate->path }}">
                        <iframe src="{{ asset('storage/' . $newsupdate->path) }}"></iframe>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Status</label>
                        <select class="form-select" name="status" value="{{ $newsupdate->status }}">
                            <option value="1" {{ $newsupdate->status == 1 ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ $newsupdate->status == 0 ? 'selected' : '' }}>Unpublished</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update News</button>
                    <a href="{{ route('news-updates.index') }}" class="btn btn-secondary mt-3">Back</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
