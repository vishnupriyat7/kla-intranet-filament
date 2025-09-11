@if (isset($results) && count($results) > 0)
    <div class="table-responsive">
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
                        @if ($orderType == 'G')
                            <td class='text-nowrap'>
                                G.O.({{ $result->go_type == 'M' ? 'Ms' : ($result->go_type == 'R' ? 'Rt' : ($result->go_type == 'P' ? 'P' : '')) }}).No.{{ $result->number }}
                            </td>
                        @elseif($orderType == 'O')
                            <td>OO.No.{{ $result->number }}</td>
                        @else
                            <td class='text-nowrap'>Cir.No.{{ $result->number ?? 'N/A' }}</td>
                        @endif
                        {{-- <td class='text-nowrap'>
                            {{ $result->date
                                ? \Carbon\Carbon::parse($result->date)->format('d-m-Y')
                                : ($result->published_date
                                    ? \Carbon\Carbon::parse($result->published_date)->format('d-m-Y')
                                    : 'N/A') }}
                        </td> --}}
                        <td class='text-nowrap'>
                            {{ $result->date ? \Carbon\Carbon::parse($result->date)->format('d-m-Y') : 'N/A' }}
                             {{-- {{ $result->date ?? 'N/A' }} --}}
                        </td>
                        <td>{{ $result->title ?? 'N/A' }}</td>
                        {{-- Display the section name--}}
                    <td>{{ $result->section->name ?? 'N/A' }}</td>

                        <td>
                            @if (isset($result->path))
                                <a href="{{ asset('storage/' . $result->path) }}" class="h6" data-bs-toggle="modal"
                                    data-bs-target="#pdfModal" data-pdf="{{ asset('storage/' . $result->path) }}"
                                    data-title="{{ $result->title }}">
                                    <i class="bi bi-eye-fill" style="font-size:18px;color:rgb(60, 93, 240)"></i>
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
