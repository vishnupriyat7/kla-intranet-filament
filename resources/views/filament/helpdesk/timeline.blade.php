<div class="py-12 px-6 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800">
    <div class="relative w-full max-w-5xl mx-auto">
        @php
            $histories = $getRecord()->statusHistories->sortBy('created_at');
            $statuses = [
                ['key' => 'Open', 'label' => 'Ticket Raised', 'sub' => 'Initial submission', 'icon' => '<path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />'],
                ['key' => 'Assigned', 'label' => 'Technician Assigned', 'sub' => 'CHM Allocated', 'icon' => '<path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25V13.5a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />'],
                ['key' => 'InProgress', 'label' => 'In Progress', 'sub' => 'Being fixed', 'icon' => '<path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.11-.414.03L6.23 4.714a1.875 1.875 0 00-2.652 0l-.707.707a1.875 1.875 0 000 2.652l1.123 1.123c.08.08.085.248-.03.414a7.496 7.496 0 00-.57.986c-.088.182-.228.277-.348.297L1.817 11.05a1.875 1.875 0 00-1.567 1.85v1a1.875 1.875 0 001.567 1.85l1.229.205c.12.02.26.115.348.297.165.34.356.67.57.986.115.166.11.334.03.414l-1.123 1.123a1.875 1.875 0 000 2.652l.707.707a1.875 1.875 0 002.652 0l1.123-1.123c.08-.08.248-.085.414.03a7.49 7.49 0 00.986.57c.182.088.277.228.297.348l.205 1.229c.151.904.933 1.567 1.85 1.567h1c.917 0 1.699-.663 1.85-1.567l.205-1.229c.02-.12.115-.26.297-.348.34-.165.67-.356.986-.57.166-.115.334-.11.414-.03l1.123 1.123a1.875 1.875 0 002.652 0l.707-.707a1.875 1.875 0 000-2.652l-1.123-1.123c-.08-.08-.085-.248.03-.414.214-.316.405-.647.57-.986.088-.182.228-.277.348-.297l1.229-.205a1.875 1.875 0 001.567-1.85v-1a1.875 1.875 0 00-1.567-1.85l-1.229-.205c-.12-.02-.26-.115-.348-.297a7.494 7.494 0 00-.57-.986c-.115-.166-.11-.334-.03-.414l1.123-1.123a1.875 1.875 0 000-2.652l-.707-.707a1.875 1.875 0 00-2.652 0l-1.123 1.123c-.08.08-.248.085-.414-.03a7.49 7.49 0 00-.986-.57c-.182-.088-.277-.228-.297-.348l-.205-1.229A1.875 1.875 0 0014.078 2.25h-1zm1.422 10.25a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" clip-rule="evenodd" />'],
                ['key' => 'Resolved', 'label' => 'Resolved', 'sub' => 'Work completed', 'icon' => '<path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />']
            ];
            $currentStatus = $getRecord()->status;
            if ($currentStatus === 'In Progress') $currentStatus = 'InProgress';

            $currentIndex = -1;
            foreach($statuses as $index => $s) {
                if ($s['key'] === $currentStatus) {
                    $currentIndex = $index;
                    break;
                }
            }
            if ($currentStatus === 'Resolved') $currentIndex = 3;

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
                    if (!$historyEntry && $status['key'] === 'InProgress') {
                        $historyEntry = $histories->firstWhere('status', 'In Progress');
                    }
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
                                {{ ($index === 0 ? $getRecord()->created_at : $historyEntry->created_at)->format('M d, Y') }}
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
                                {{ ($index === 0 ? $getRecord()->created_at : $historyEntry->created_at)->format('H:i') }}
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
