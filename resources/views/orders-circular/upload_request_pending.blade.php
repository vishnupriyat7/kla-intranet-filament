@if(isset($order_pendings) && count($order_pendings) > 0)
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Number</th>
                <th>Title</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order_pendings as $order_pending)
                <tr>
                    <td>{{ $order_pending->number }}</td>
                    <td>{{ $order_pending->title }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- @else
    <p>No Pending Requests</p> --}}
</div>
@endif
