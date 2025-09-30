@extends('layouts.default')

@section('content')
    <!-- Single Product Start -->
    <div class="container-fluid populer-news py-3">
        <div class="container">
            <h1>New Order/Circular Upload Request</h1>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#checkStatusModal">
                    Check Status
                </button>
            </div>
            </br>
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="container py-12 d-flex justify-content-center">
                <div class="card col-12">
                    <div class="card-body">
                        <form action="{{ route('home.store-upload-request') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <select class="form-select" id="section_fe" name="section" required>
                                    <option value="">Select Section</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="mb-3 col-12" id="type-fe-div">
                                    <select class="form-select" id="type_fe" name="type" required onchange="toggleGoType()">
                                        <option value="">Select Order Type</option>
                                        <option value="G">Government Order</option>
                                        <option value="O">Office Order</option>
                                        <option value="C">Circular</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-6" id="goType_fe" style="display: none">
                                    <select class="form-select" id="go_type_fe" name="go_type" required>
                                        <option value="">Select GO Type</option>
                                        <option value="M">സർക്കാർ ഉത്തരവുകൾ കയ്യെഴുത്തു (Govt.Order Manuscript)
                                        </option>
                                        <option value="R">സർക്കാർ ഉത്തരവുകൾ സാധാ (Govt.Order Routine)</option>
                                        <option value="P">സർക്കാർ ഉത്തരവുകൾ അച്ചടി (Govt. Order Print) </option>
                                    </select>
                                    @error('go_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6" id="service_member_fe">
                                    <select class="form-select" id="serviceMember_fe" name="serviceMember" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('serviceMember')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-6" id="category-fe-div">
                                    <select class="form-select" id="category_fe" name="category" required>
                                        <option value="">Select Category</option>
                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <input type="text" class="form-control" id="no_fe" name="no"
                                        placeholder="Enter Order/Circular Number" required>
                                    @error('no')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-6">
                                    <input type="date" class="form-control" id="date_fe" name="date"
                                        placeholder="Enter Date" required>
                                    @error('date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" id="title_fe" name="title" placeholder="Enter Title"
                                    required></textarea>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <textarea type="text" class="form-control" id="keywords_fe" name="keywords"
                                    placeholder="Enter Keywords"></textarea>
                                @error('keywords')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="file" class="form-control" id="path_fe" name="path" required>
                                @error('path')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->
    <!-- Modal -->
    <div class="modal fade" id="checkStatusModal" tabindex="-1" aria-labelledby="checkStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="checkStatusModalLabel">Check Status</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('home.check-upload-request') }}" method="GET" enctype="multipart/form-data"
                        id="uploadRequestStatusForm">
                        @csrf
                        <select class="form-select mb-2" id="section_status" name="section_status" required>
                            <option value="">Select Section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="container d-flex justify-content-end">
                            <button type="submit" class="btn btn-success mt-3">Check</button>
                        </div>
                    </form>
                    <div class="row" id="pending_results">
                        @include('orders-circular.upload_request_pending')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function toggleGoType() {
        var type = document.getElementById('type_fe').value;
        var select = document.getElementById('category_fe');
        var optionToRemove = select.querySelector('option[value="PA"]');
        if (type !== 'C') {
            if (!optionToRemove) {
                var newOption = document.createElement('option');
                newOption.value = "PA";
                newOption.textContent = "PA Posting";
                select.appendChild(newOption);
            }
        }
        if (type === 'G') {
            document.getElementById('goType_fe').style.display = 'block';
            document.getElementById('go_type_fe').setAttribute('required', 'required');
            document.getElementById('serviceMember_fe').style.display = 'block';
            document.getElementById('serviceMember_fe').setAttribute('required', 'required');
            document.getElementById('type-fe-div').classList.replace('col-12', 'col-6');
            document.getElementById('goType_fe').classList.replace('col-12', 'col-6');
            document.getElementById('category-fe-div').classList.replace('col-12', 'col-6');
        } else if (type === 'C') {
            document.getElementById('goType_fe').style.display = 'none';
            document.getElementById('go_type_fe').removeAttribute('required');
            document.getElementById('go_type_fe').value = '';
            document.getElementById('serviceMember_fe').style.display = 'none';
            document.getElementById('serviceMember_fe').removeAttribute('required');
            document.getElementById('serviceMember_fe').value = '';
            document.getElementById('type-fe-div').classList.replace('col-6', 'col-12');
            document.getElementById('category-fe-div').classList.replace('col-6', 'col-12');
            optionToRemove.remove();
        } else {
            document.getElementById('goType_fe').style.display = 'none';
            document.getElementById('go_type_fe').removeAttribute('required');
            document.getElementById('go_type_fe').value = '';
            document.getElementById('serviceMember_fe').style.display = 'block';
            document.getElementById('serviceMember_fe').setAttribute('required', 'required');
            document.getElementById('goType_fe').classList.replace('col-6', 'col-12');
            document.getElementById('type-fe-div').classList.replace('col-6', 'col-12');
            document.getElementById('category-fe-div').classList.replace('col-12', 'col-6');
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("uploadRequestStatusForm");
        const resultsContainer = document.getElementById("pending_results");

        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();

            fetch(form.action + "?" + params, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
                .then(response => response.text())
                .then(html => {
                    if (resultsContainer) {
                        resultsContainer.innerHTML = html;
                    } else {
                        console.error("No pending requests!");
                    }
                })
                .catch(error => {
                    console.error("AJAX Search Error:", error);
                });
        });
    });
</script>
