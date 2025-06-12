<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-12">
        <div class="card">
            <div class="card-header p-3">

                <h2 class="fw-bold">Add New Order / Circular</h2>
            </div>
            <div class="card-body">

                <form action="{{ route('orders-circular.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="type" class="form-label">Select Section</label>
                        <select class="form-select" id="section" name="section" required>
                            <option value="">Select Section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Select Type</label>
                        <select class="form-select" id="type" name="type" required onchange="toggleGoType()">
                            <option value="">Select Type</option>
                            <option value="G">Govt Order</option>
                            <option value="O">Office Order</option>
                            <option value="C">Circular</option>
                        </select>
                        @error('type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- I want to display select GO Type only if Type is Govt Order --}}
                    <div class="mb-3" id="goType" style="display: none">
                        <label for="go_type" class="form-label">Select GO Type</label>
                        <select class="form-select" id="go_type" name="go_type" required
                            onchange="toggleServiceorMember()">
                            <option value="">Select GO Type</option>
                            <option value="M">സർക്കാർ ഉത്തരവുകൾ കയ്യെഴുത്തു (Govt.Order Manuscript)</option>
                            <option value="R">സർക്കാർ ഉത്തരവുകൾ സാധാ (Govt.Order Routine)</option>
                            <option value="P">സർക്കാർ ഉത്തരവുകൾ അച്ചടി (Govt. Order Print) </option>

                        </select>
                        @error('go_type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- I want to display select MS Type only if GO Type is Govt Order Manuscript --}}
                    <div class="mb-3" id="service_member" style="display: none">
                        <label for="service_member" class="form-label">Select Service / Member Related</label>
                        <select class="form-select" id="serviceMember" name="serviceMember" required
                            onchange="toggleServiceMember()">
                            <option value="">Select Service / Member Related</option>
                            <option value="Service">Service Related</option>
                            <option value="Member">Members Related</option>

                        </select>
                        @error('service_member')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- I want to display select Service only if Service / Member Related is Service Related --}}
                    <div class="mb-3" id="service_member_category" style="display: none">
                        <label for="service_member_category" class="form-label">Select Category</label>
                        <select class="form-select" id="servc_memb_catgry" name="servc_memb_catgry" required>
                            <option value="">Select Category</option>
                            <option value="CR">Claim / Reimbursements</option>
                            <option value="TP">Transfer & Posting</option>
                            <option value="PA">PA Postings</option>
                            <option value="AR">Accounts Related</option>
                            <option value="G">General</option>
                        </select>
                        @error('service')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- I want to display select Member only if Service / Member Related is Members Related --}}
                    {{-- <div class="mb-3" id="member" style="display: none">
                        <label for="member" class="form-label">Select Member</label>
                        <select class="form-select" id="memb" name="memb" required>
                            <option value="">Select Member Related</option>
                            <option value="MCR">Claim / Reimbursements</option>
                            <option value="PA">PA Postings</option>
                            <option value="MAR">Accounts Related</option>

                        </select>
                        @error('member')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div class="mb-3">
                        <label for="no" class="form-label">Number</label>
                        <input type="text" class="form-control" id="no" name="no" placeholder="Enter No" required>
                        @error('no')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" placeholder="Enter Date" required>
                        @error('date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title"
                            required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="keywords" class="form-label">Keyword</label>
                        <input type="text" class="form-control" id="keywords" name="keywords"
                            placeholder="Enter Keyword" required>
                        @error('keywords')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="path" class="form-label">Choose File</label>
                        <input type="file" class="form-control" id="path" name="path" required>
                        @error('path')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Add Select Box for Orders/Circulars List Published(1) /Unpublished(0) --}}

                    <div class="mb-3">
                        <label for="status" class="form-label">Published / Unpublished</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Select Published / Unpublished</option>
                            <option value="1">Published</option>
                            <option value="0">Unpublished</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('orders-circular.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
            document.getElementById('go_type').value = '';
        } else {
            document.getElementById('service_member_category').style.display = 'block';
            document.getElementById('servc_memb_catgry').setAttribute('required', 'required');
            document.getElementById('goType').style.display = 'none';
            document.getElementById('go_type').removeAttribute('required');
            document.getElementById('go_type').value = '';
            document.getElementById('service_member').style.display = 'none';
            document.getElementById('serviceMember').removeAttribute('required');
            document.getElementById('serviceMember').value = 'Service';
            // document.getElementById('member').style.display = 'none';
            // document.getElementById('memb').removeAttribute('required');
            // Remove PA Postings option if type == Circular
            var paOption = document.getElementById('service_member_category').querySelector('option[value="PA"]');
            if (type == 'C' && paOption) {
                paOption.remove();
            }
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
        var serviceMember = document.getElementById('serviceMember').value;
        // dd(serviceMember);

        if (serviceMember === "Service" || serviceMember === "Member") {
            document.getElementById('service_member_category').style.display = 'block';
            document.getElementById('servc_memb_catgry').setAttribute('required', 'required');
        }

        // if (serviceMember === 'Service') {
        //     document.getElementById('service').style.display = 'block';
        //     document.getElementById('servc').setAttribute('required', 'required');
        //     document.getElementById('member').style.display = 'none';
        //     document.getElementById('memb').removeAttribute('required');
        // } else if (serviceMember === 'Member') {
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
