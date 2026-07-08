<div class="py-12 px-2 md:px-6 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-x-auto">
    <div class="relative w-full max-w-5xl mx-auto min-w-[700px] px-2 md:px-4">
        @php
            $histories = $getRecord()->statusHistories->sortBy('created_at');
            $statuses = [
                ['key' => 'Open', 'label' => 'Ticket Raised', 'sub' => 'Initial submission', 'icon' => '<path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />'],
                ['key' => 'Assigned', 'label' => 'Technician Assigned', 'sub' => 'CHM Allocated', 'icon' => '<path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25V13.5a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />'],
                ['key' => 'Pending', 'label' => 'Pending', 'sub' => 'Awaiting info', 'icon' => '<path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />'],
                ['key' => 'Complaint', 'label' => 'Complaint', 'sub' => 'Issue raised', 'icon' => '<path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.401 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />'],
                ['key' => 'Resolved', 'label' => 'Resolved', 'sub' => 'Work completed', 'icon' => '<path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />']
            ];
            $currentStatus = $getRecord()->status;

            $currentIndex = -1;
            foreach($statuses as $index => $s) {
                if ($s['key'] === $currentStatus) {
                    $currentIndex = $index;
                    break;
                }
            }
            // If ticket is resolved, ensure it shows full progress even if index is last
            if ($currentStatus === 'Resolved') $currentIndex = count($statuses) - 1;

            $progressWidth = ($currentIndex >= 0) ? ($currentIndex / (count($statuses) - 1)) * 100 : 0;
        @endphp

        <!-- 100% RELIABLE TRACK: Background gray line -->
        <div style="position: absolute; top: 88px; left: 0; right: 0; height: 4px; background-color: #e5e7eb; border-radius: 99px; z-index: 0;"></div>

        <!-- 100% RELIABLE PROGRESS: Blue line -->
        <div style="position: absolute; top: 88px; left: 0; width: {{ $progressWidth }}%; height: 4px; background-color: #2563eb; border-radius: 99px; z-index: 1; transition: width 1s ease;"></div>

        <div class="relative flex justify-between items-start w-full" style="z-index: 10;">
            @foreach($statuses as $index => $status)
                @php
                    $historyEntry = $histories->firstWhere('status', $status['key']);
                    if (!$historyEntry && $status['key'] === 'Open') {
                         $historyEntry = $getRecord(); 
                    }

                    $isReached = ($index <= $currentIndex);
                    $isActive = ($status['key'] === $currentStatus);

                    $circleColor = $isReached ? '#2563eb' : '#ffffff';
                    $iconColor = $isReached ? '#ffffff' : '#9ca3af';
                    $borderColor = $isReached ? '#2563eb' : '#e5e7eb';
                @endphp

                <div class="flex-1 flex flex-col items-center">
                    <!-- Date Area (h-16 = 64px) -->
                    <div style="height: 64px;" class="flex flex-col justify-end pb-4 text-center">
                        @if($historyEntry)
                            <span style="color: {{ $isReached ? '#1d4ed8' : '#9ca3af' }}; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em;">
                                {{ ($index === 0 ? $getRecord()->created_at : $historyEntry->created_at)->timezone('Asia/Kolkata')->format('M d, Y') }}
                            </span>
                        @endif
                    </div>

                    <!-- Circle Area (h-12 = 48px) -->
                    <div style="height: 48px;" class="flex items-center justify-center relative">
                        <div style="width: 48px; height: 48px; border-radius: 50%; border: 4px solid {{ $borderColor }}; background-color: {{ $circleColor }}; display: flex; align-items: center; justify-content: center; position: relative; z-index: 20; box-shadow: 0 1px 2px rgba(0,0,0,0.05); {{ $isActive ? 'transform: scale(1.2); outline: 8px solid rgba(37, 99, 235, 0.1);' : '' }}">
                            <svg style="width: 24px; height: 24px; fill: {{ $iconColor }};" viewBox="0 0 24 24">
                                {!! $status['icon'] !!}
                            </svg>
                        </div>
                    </div>

                    <!-- Labels Area -->
                    <div style="padding-top: 32px;" class="text-center px-2">
                        <h4 style="font-size: 13px; font-weight: 800; color: {{ $isReached ? '#111827' : '#9ca3af' }};">
                            {{ $status['label'] }}
                        </h4>
                        <p style="font-size: 10px; margin-top: 4px; color: {{ $isReached ? '#6b7280' : '#d1d5db' }};">
                            {{ $status['sub'] }}
                        </p>
                        @if($historyEntry)
                            <div style="margin-top: 12px; font-size: 10px; font-weight: 900; color: #1d4ed8; background-color: #eff6ff; padding: 4px 12px; border-radius: 99px; display: inline-block;">
                                {{ ($index === 0 ? $getRecord()->created_at : $historyEntry->created_at)->timezone('Asia/Kolkata')->format('h:i A') }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Summary Footer -->
    <div style="margin-top: 32px; padding-top: 32px; border-top: 1px solid #f3f4f6;" class="flex justify-center">
        <div style="display: inline-flex; align-items: center; padding: 10px 24px; border-radius: 99px; background-color: #f9fafb; border: 1px solid #f3f4f6; color: #374151; font-size: 11px; font-weight: 700;">
            <svg style="width: 16px; height: 16px; margin-right: 10px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            @if($getRecord()->status === 'Resolved')
                RESOLUTION TIME: {{ $getRecord()->created_at->diffForHumans($getRecord()->updated_at, true) }}
            @else
                ELAPSED TIME: {{ $getRecord()->created_at->diffForHumans(null, true) }}
            @endif
        </div>
    </div>
</div>
