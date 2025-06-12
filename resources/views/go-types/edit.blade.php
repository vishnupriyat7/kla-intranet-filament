<x-app-layout>
    <div class="container">
        <h2 class="mb-4">Edit</h2>
        <form action="{{ route('go-types.update', $goType->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="go_type" class="form-label">Go Type</label>
                <input type="text" class="form-control" id="go_type" name="go_type" value="{{ $goType->go_type }}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</x-app-layout>
