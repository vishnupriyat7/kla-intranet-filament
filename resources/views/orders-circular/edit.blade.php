{{-- Edit page for create form --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Order / Circular
        </h2>
    </x-slot>

    <div class="container py-10">
        <div class="card">
            <div class="card-header p-3">
                <h1 class="fw-bold">Edit Order / Circular</h1>
            </div>

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('orders-circular.update', $order->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group mb-3">
                        <label for="type" class="form-label">Select Type</label>
                        <select class="form-select" id="type" name="type" required onchange="toggleGoType()">
                            <option value="">Select Type</option>
                            <option value="G" {{ $order->type == 'G' ? 'selected' : '' }}>Govt Order</option>
                            <option value="O" {{ $order->type == 'O' ? 'selected' : '' }}>Office Order</option>
                            <option value="C" {{ $order->type == 'C' ? 'selected' : '' }}>Circular</option>
                        </select>

                    </div>
                    <div class="form-group mb-3" id="goType" style="display: none">
                        <label for="go_type" class="form-label">Select GO Type</label>
                        <select class="form-select" id="go_type" name="go_type" required
                            onchange="toggleServiceorMember()">
                            <option value="">Select GO Type</option>
                            <option value="M" {{ $order->go_type == 'M' ? 'selected' : '' }}>സർക്കാർ ഉത്തരവുകൾ
                                കയ്യെഴുത്തു (Govt.Order Manuscript)</option>
                            <option value="R" {{ $order->go_type == 'R' ? 'selected' : '' }}>സർക്കാർ ഉത്തരവുകൾ സാധാ
                                (Govt.Order Routine)</option>
                            <option value="P" {{ $order->go_type == 'P' ? 'selected' : '' }}>സർക്കാർ ഉത്തരവുകൾ
                                അച്ചടി
                                (Govt. Order Print) </option>
                        </select>
                    </div>
                    <div class="mb-3" id="service_member" style="display: none">
                        <label for="service_member" class="form-label">Select Service / Member Related</label>
                        <select class="form-select" id="serviceMember" name="serviceMember"
                            onchange="toggleServiceMember()">
                            <option value="">Select Service / Member Related</option>
                            <option value="Service" {{ $order->sub_type == 'Service' ? 'selected' : '' }}>Service
                                Related</option>
                            <option value="Member" {{ $order->sub_type == 'Member' ? 'selected' : '' }}>Members
                                Related</option>
                        </select>
                        @error('service_member')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3" id="service_member_category" style="display: none">
                        <label for="Category" class="form-label">Category</label>
                        <select class="form-select" id="servc_memb_cat" name="servc_memb_cat">
                            <option value="">Select Category</option>
                            <option value="TP" {{ $order->sub_sub_type == 'TP' ? 'selected' : '' }}>Transfer &
                                Posting
                            </option>
                            <option value="PA" {{ $order->sub_sub_type == 'PA' ? 'selected' : '' }}>PA Postings
                            </option>
                            <option value="CR" {{ $order->sub_sub_type == 'CR' ? 'selected' : '' }}>Claim /
                                Reimbursements</option>
                            <option value="AR" {{ $order->sub_sub_type == 'AR' ? 'selected' : '' }}>Accounts
                                Related
                            </option>
                            <option value="G" {{ $order->sub_sub_type == 'G' ? 'selected' : '' }}>General</option>
                        </select>
                        @error('service')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div class="mb-3" id="member" style="display: none">
                        <label for="member" class="form-label">Select Member</label>
                        <select class="form-select" id="memb" name="memb">
                            <option value="">Select Member Related</option>
                            <option value="MCR" {{ $order->sub_sub_type == 'MCR' ? 'selected' : '' }}>Claim /
                                Reimbursements
                            </option>
                            <option value="PA" {{ $order->sub_sub_type == 'PA' ? 'selected' : '' }}>PA Postings
                            </option>
                            <option value="MAR" {{ $order->sub_sub_type == 'MAR' ? 'selected' : '' }}>Accounts
                                Related
                            </option>
                        </select>
                        @error('member')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div class="form-group mb-3">
                        <label for="no" class="form-label">Number</label>
                        <input type="text" class="form-control" id="no" name="no"
                            value="{{ $order->number }}">
                        @error('no')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date"
                            value="{{ $order->date }}">
                        @error('date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $order->title }}">
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="keywords" class="form-label">Keywords</label>
                        <input type="text" class="form-control" id="keywords" name="keywords"
                            value="{{ $order->keywords }}">
                        @error('keywords')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-6">
                            @if ($order->path)
                                <a href="#" data-bs-toggle="modal" class="btn btn-success btn-sm"
                                    data-bs-target="#pdfModal">
                                    View PDF
                                </a>
                            @else
                                <p>No PDF available</p>
                            @endif
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="path" class="form-label">Choose File</label>
                                <input type="file" class="form-control" id="path" name="path">

                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>Unpublished</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('orders-circular.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
{{-- Script to toggle GO Type --}}
{{-- PDF MODAL  --}}

<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe src="{{ asset('storage/' . $order->path) }}" width="100%" height="500px"
                    style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        toggleGoType();
        toggleServiceorMember();
        toggleServiceMember();
    });

    function toggleGoType() {
        var type = document.getElementById('type').value;
        if (type == 'G') {
            document.getElementById('goType').style.display = 'block';
            document.getElementById('go_type').setAttribute('required', 'required');
        } else if (type == 'O') {
            document.getElementById('service_member').style.display = 'block';
            document.getElementById('serviceMember').setAttribute('required', 'required');
            document.getElementById('goType').style.display = 'none';
            document.getElementById('go_type').removeAttribute('required');

        } else {
            document.getElementById('service_member_category').style.display = 'block';
            document.getElementById('servc_memb_cat').setAttribute('required', 'required');
            document.getElementById('goType').style.display = 'none';
            document.getElementById('go_type').removeAttribute('required');
            document.getElementById('service_member').style.display = 'none';
            document.getElementById('serviceMember').removeAttribute('required');
            // document.getElementById('member').style.display = 'none';
            // document.getElementById('memb').removeAttribute('required');
        }
    }

    function toggleServiceorMember() {
        var go_type = document.getElementById('go_type').value;
        if (go_type == 'M' || go_type == 'R' || go_type == 'P') {
            document.getElementById('service_member').style.display = 'block';
            document.getElementById('service_member').setAttribute('required', 'required');
        }
        // else {
        //     document.getElementById('service_member').style.display = 'none';
        //     document.getElementById('service_member').removeAttribute('required');
        // }
    }

    function toggleServiceMember() {
        var serviceMemberCategory = document.getElementById('serviceMember').value;

        if (serviceMemberCategory === "Service" || serviceMemberCategory === "Member") {
            document.getElementById('service_member_category').style.display = 'block';
            document.getElementById('servc_memb_cat').setAttribute('required', 'required');
            // document.getElementById('member').style.display = 'none';
            // document.getElementById('memb').removeAttribute('required');
        }
        // else if (serviceMember === 'Member') {
        //     document.getElementById('member').style.display = 'block';
        //     document.getElementById('memb').setAttribute('required', 'required');
        //     document.getElementById('service').style.display = 'none';
        //     document.getElementById('servc').removeAttribute('required');
        // } else {
        //     document.getElementById('service').style.display = 'none';
        //     document.getElementById('servc').removeAttribute('required');
        //     document.getElementById('member').style.display = 'none';
        //     document.getElementById('memb').removeAttribute('required');
        // }
    }
</script>
