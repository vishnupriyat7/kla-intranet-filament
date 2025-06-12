<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container py-10">

        <div class="card">

            <div class="card-header p-3">
                <h1 class="fw-bold">Show Periodical</h1>
            </div>
            <div class="card-body">
                <!-- Display Details in a Table -->
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 20%;">Name</th>
                            <td>{{ $periodical->periodicalMaster->name }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $periodical->date }}</td>
                        </tr>
                        <tr>
                            <th>Keywords</th>
                            <td>{{ $periodical->keywords }}</td>
                        </tr>
                        <tr>
                            <th>Path</th>
                            <td>{{ $periodical->path }}</td>
                        </tr>

                        <tr>
                            <th>File</th>
                            <td>
                                @if ($periodical->path)
                                    <!-- Trigger the modal to view the PDF -->
                                    <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#pdfModal{{ $periodical->id }}">
                                        View PDF
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="pdfModal{{ $periodical->id }}" tabindex="-1"
                                        aria-labelledby="pdfModalLabel{{ $periodical->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="pdfModalLabel{{ $periodical->id }}">PDF
                                                        Preview</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <iframe src="{{ asset('storage/' . $periodical->path) }}"
                                                        width="100%" height="500px" style="border: none;"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Default fallback -->
                                    <span>No image or PDF available</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Back Button -->
                <a href="{{ route('periodicals.index') }}" class="btn btn-secondary mt-4">Back</a>
            </div>
        </div>
    </div>
</x-app-layout>
