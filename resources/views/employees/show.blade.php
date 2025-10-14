<div class="card">
    <div class="card-body">
        <div class="row">
            <!-- Left side: Employee Details -->
            <div class="col-md-8">
                <h5 class="card-title">{{ $filteredEmployee['name'] }}</h5>
                <p class="card-text"><strong>Designation:</strong>
                    {{ $filteredEmployee['designation'] ?? 'N/A' }} </p>
                <p class="card-text"><strong>Section:</strong>
                    {{ $filteredEmployee['section'] ? $filteredEmployee['section'] : 'N/A' }}</p>
                {{-- <p class="card-text"><strong>Pen:</strong>
                    {{ $filteredEmployee['pen'] ? $filteredEmployee['pen'] : 'N/A' }}</p>
                <p class="card-text"><strong>Attendance Id:</strong>
                    {{ $filteredEmployee['attendanceId'] }}</p> --}}
                <p class="card-text"><strong>KLA Id:</strong>
                    {{ $filteredEmployee['klaid'] ? $filteredEmployee['klaid'] : 'N/A'}}</p>
                <p class="card-text"><strong>Mobile:</strong>
                    {{ $filteredEmployee['mobile'] ? $filteredEmployee['mobile'] : 'N/A' }}</p>
                <p class="card-text"><strong>Email:</strong>
                    {{ $filteredEmployee['email'] ? $filteredEmployee['email'] : 'N/A' }}</p>
            </div>

            <!-- Right side: Employee Image -->
            <div class="col-md-4 text-center">
                @if($filteredEmployee['avatar'])
                    <img src="{{ env('EMPLOYEE_IMG_URL') . '/' . $filteredEmployee['avatar'] }}" alt="Employee Photo"
                        class="img-fluid rounded">
                @else
                    <p>No Photo Available</p>
                @endif
            </div>
        </div>
    </div>
</div>
