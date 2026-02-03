@if (isset($error))
    <div class="alert alert-danger mt-4">{{ $error }}</div>

@elseif (isset($results))

    @if ($results->count() > 0)

        <div class="table-responsive">

            {{-- SUMMARY CARDS --}}
            <div class="row mt-0">
                @php
                    $typeCounts = $results->groupBy('type')->map->count();
                    $goTypeCounts = $results->where('type', 'G')->groupBy('go_type')->map->count();

                    $goTypes = ['M' => 'MS', 'R' => 'RT', 'P' => 'P'];

                    $goSplit = $goTypeCounts
                        ->map(fn($count, $key) => ($goTypes[$key] ?? $key) . ':' . $count)
                        ->implode(', ');
                @endphp

                @if (isset($typeCounts['G']))
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light shadow-sm text-center">
                            <div class="card-body">
                                <h6>Government Order</h6>
                                <h5>GO-{{ $typeCounts['G'] }}
                                    @if ($goSplit)
                                        <small class="text-muted">({{ $goSplit }})</small>
                                    @endif
                                </h5>
                            </div>
                        </div>
                    </div>
                @endif

                @if (isset($typeCounts['O']))
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light shadow-sm text-center">
                            <div class="card-body">
                                <h6>Office Order</h6>
                                <h5>{{ $typeCounts['O'] }}</h5>
                            </div>
                        </div>
                    </div>
                @endif

                @if (isset($typeCounts['C']))
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light shadow-sm text-center">
                            <div class="card-body">
                                <h6>Circular</h6>
                                <h5>{{ $typeCounts['C'] }}</h5>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- RESULT TABLE --}}
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
                        @php
                            $attachments = is_array($result->path) ? $result->path : [];
                        @endphp

                        <tr>
                            <td>{{ $index + 1 }}</td>

                            {{-- NUMBER --}}
                            <td class="text-nowrap">
                                @if ($result->type === 'G')
                                    G.O.({{ $result->go_type === 'M' ? 'Ms' : ($result->go_type === 'R' ? 'Rt' : 'P') }}).No.{{ $result->number }}
                                @elseif ($result->type === 'O')
                                    OO.No.{{ $result->number }}
                                @elseif ($result->type === 'C')
                                    Cir.No.{{ $result->number }}
                                @else
                                    N/A
                                @endif
                            </td>

                            {{-- DATE --}}
                            <td class="text-nowrap">
                                {{ $result->date ? \Carbon\Carbon::parse($result->date)->format('d-m-Y') : 'N/A' }}
                            </td>

                            {{-- TITLE --}}
                            <td>{!! $result->title ?? 'N/A' !!}</td>

                            {{-- SECTION --}}
                            <td>{{ $result->section->name ?? 'N/A' }}</td>

                            {{-- ATTACHMENTS --}}
                            <td class="text-nowrap">

                                {{-- SINGLE FILE --}}
                                @if (count($attachments) === 1)
                                    <a href="#"
                                       data-bs-toggle="modal"
                                       data-bs-target="#pdfModal"
                                       data-pdf="{{ asset('storage/' . $attachments[0]) }}"
                                       data-title="{{ $result->title }}">
                                        <i class="bi bi-eye-fill text-primary fs-5"></i>
                                    </a>

                                    <a href="{{ asset('storage/' . $attachments[0]) }}"
                                       target="_blank"
                                       class="ms-2">
                                        <i class="bi bi-box-arrow-up-right text-success fs-5"></i>
                                    </a>

                                {{-- MULTIPLE FILES --}}
                                @elseif (count($attachments) > 1)
                                    @foreach ($attachments as $i => $file)
                                        <a href="#"
                                           class="badge bg-light text-primary border me-2"
                                           data-bs-toggle="modal"
                                           data-bs-target="#pdfModal"
                                           data-pdf="{{ asset('storage/' . $file) }}"
                                           data-title="{{ $result->title }} (Attachment {{ $i + 1 }})">
                                            📎 Attachment {{ $i + 1 }}
                                        </a>
                                    @endforeach

                                {{-- NO FILE --}}
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
        <div class="alert alert-danger mt-4">No data available for these parameters.</div>
    @endif

@else
    <div class="alert alert-warning mt-4">
        Please select at least one search parameter to proceed.
    </div>
@endif
