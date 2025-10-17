<div class="card">
    <div class="card-header">
        <h3 class="card-title">Retired Staff Details</h3>
    </div>
    <div class="card-body">
        @if (isset($error))
            <div class="alert alert-danger">{{ $error }}</div>
        @else
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ $retiredStaff->getFirstMediaUrl('images') }}" alt="{{ $retiredStaff->name_eng }}"
                        class="img-fluid rounded" onerror="this.src='https://via.placeholder.com/100'">
                </div>
                <div class="col-md-8">
                    <p><strong>Name (English):</strong> {{ $retiredStaff->name_eng ?? 'N/A' }}</p>
                    <p><strong>Name (Malayalam):</strong> {{ $retiredStaff->name_mal ?? 'N/A' }}</p>
                    <p><strong>Retired As:</strong> {{ $retiredStaff->retired_as ?? 'N/A' }}</p>
                    <p><strong>Retired On:</strong> {{ $retiredStaff->retired_on ?? 'N/A' }}</p>
                    <p><strong>District:</strong> {{ $retiredStaff->district ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ $retiredStaff->address ?? 'N/A' }}</p>
                    <p><strong>PIN:</strong> {{ $retiredStaff->pin ?? 'N/A' }}</p>
                    <p><strong>Contact No:</strong> {{ $retiredStaff->contact_no ?? 'N/A' }}</p>
                    <p><strong>KLA ID:</strong> {{ $retiredStaff->kla_id ?? 'N/A' }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
