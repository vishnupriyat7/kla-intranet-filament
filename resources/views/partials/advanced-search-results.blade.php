@if (isset($error))
    <div class="alert alert-danger mt-4">{{ $error }}</div>
@elseif (isset($results))
    @if (count($results) > 0)
        <div class="table-responsive">
            <!-- Debugging: Display type counts -->
            <div class="row mt-0">
                @php
                    $typeCounts = $results->groupBy('type')->map->count();

                    // Short labels
                    $types = [
                        'G' => 'GO',
                        'O' => 'Office Order',
                        'C' => 'Circular',
                    ];

                    // Split GO sub-types
                    $goTypeCounts = $results->where('type', 'G')->groupBy('go_type')->map->count();

                    // Map short keys
                    $goTypes = [
                        'M' => 'MS',
                        'R' => 'RT',
                        'P' => 'P',
                    ];

                    // Build formatted split like (MS : 12, RT : 10, P : 8)
                    $goSplit = $goTypeCounts
                        ->map(function ($count, $key) use ($goTypes) {
                            return ($goTypes[$key] ?? $key) . ':' . $count;
                        })
                        ->implode(',');
                @endphp

                {{-- Government Order card with split --}}
                @if (isset($typeCounts['G']))
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card bg-light border border-teal-500 shadow-sm h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title mb-2">Government Order</h6>
                                <h5 class="mb-0"
                                    style="font-weight: normal; color: #111; font-family: 'Courier New', monospace;">
                                    GO-{{ $typeCounts['G'] }}
                                    @if ($goSplit)
                                        <small class="text-muted"
                                            style="font-family: inherit;">({{ $goSplit }})</small>
                                    @endif
                                </h5>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Office Order --}}
                @if (isset($typeCounts['O']))
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card bg-light border border-teal-500 shadow-sm h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title mb-2">Office Order</h6>
                                <h5 class="mb-0"
                                    style="font-weight: normal; color: #111; font-family: 'Courier New', monospace;">
                                    {{ $typeCounts['O'] }}
                                </h5>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Circular --}}
                @if (isset($typeCounts['C']))
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card bg-light border border-teal-500 shadow-sm h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title mb-2">Circular</h6>
                                <h5 class="mb-0"
                                    style="font-weight: normal; color: #111; font-family: 'Courier New', monospace;">
                                    {{ $typeCounts['C'] }}
                                </h5>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Number</th>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Section</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $index => $result)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            @if ($result->type === 'G')
                                <td class='text-nowrap'>
                                    G.O.({{ $result->go_type === 'M' ? 'Ms' : ($result->go_type === 'R' ? 'Rt' : ($result->go_type === 'P' ? 'P' : 'Unknown')) }}).No.{{ $result->number ?? 'N/A' }}
                                </td>
                            @elseif ($result->type === 'O')
                                <td class='text-nowrap'>OO.No.{{ $result->number ?? 'N/A' }}</td>
                            @elseif ($result->type === 'C')
                                <td class='text-nowrap'>Cir.No.{{ $result->number ?? 'N/A' }}</td>
                            @else
                                <td class='text-nowrap'>Unknown Type: {{ $result->type ?? 'N/A' }}</td>
                            @endif
                            <td class='text-nowrap'>
                                {{ $result->date ? \Carbon\Carbon::parse($result->date)->format('d-m-Y') : 'N/A' }}
                            </td>
                            <td>{{ $result->title ?? 'N/A' }}</td>
                            <td>{{ $result->section->name ?? 'N/A' }}</td>
                            <td class='text-nowrap'>
                                @if (isset($result->path))
                                    <a href="{{ asset('storage/' . $result->path) }}" class="h6"
                                        data-bs-toggle="modal" data-bs-target="#pdfModal"
                                        data-pdf="{{ asset('storage/' . $result->path) }}"
                                        data-title="{{ $result->title ?? 'N/A' }}">
                                        <i class="bi bi-eye-fill" style="font-size:18px;color:rgb(60, 93, 240)"></i>
                                    </a>
                                    <a href="{{ asset('storage/' . $result->path) }}" class="h6 ms-2" target="_blank"
                                        title="Open in New Tab">
                                        <i class="bi bi-box-arrow-up-right"
                                            style="font-size:18px;color:rgb(27, 122, 70)"></i>
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    @else
        <div class="alert alert-danger mt-4">No data available for these parameters...</div>
    @endif
@else
    <div class="alert alert-warning mt-4">
        Please select an Order Type / year / month / section / keyword to proceed with the search.
    </div>
@endif
