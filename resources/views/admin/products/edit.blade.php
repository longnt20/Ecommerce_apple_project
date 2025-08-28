@extends('admin.layouts.app')
@section('title', 'Cập nhật sản phẩm')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lí sản phẩm</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lí sản phẩm</a></li>
                        <li class="breadcrumb-item active">Cập nhật sản phẩm</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Cập nhật sản phẩm: {{ $product->name }}</h4>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div><!-- end card header -->
        <div class="card-body">
            <form id="product-form" method="POST" action="{{ route('admin.products.update', $product->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-7">
                        <!-- Thông tin chung -->
                        <div class="card" style="border-width: 2px;">
                            <div class="card-header" style="background-color:aliceblue">
                                <h5 class="card-title mb-0">Thông tin chung</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Tên sản phẩm</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $product->name) }}" placeholder="Nhập tên sản phẩm">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Giá mặc định</label>
                                    <input type="text" class="form-control" name="default_price"
                                        value="{{ old('default_price', $product->default_price) }}"
                                        placeholder="Nhập giá sản phẩm">
                                </div>
                                <div>
                                    <label for="description">Mô tả ngắn</label>
                                    <textarea class="form-control" name="short_description" rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Thông số kỹ thuật -->
                        <div class="card" style="border-width: 2px;">
                            <div class="card-header" style="background-color:aliceblue">
                                <h5 class="card-title mb-0">Thông số kỹ thuật</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" id="spec-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%">Tên thông số</th>
                                            <th style="width: 40%">Giá trị</th>
                                            <th style="width: 20%">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->specs as $spec)
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="specs[{{ $loop->index }}][id]"
                                                        value="{{ $spec->id }}">
                                                    <input class="form-control" type="text"
                                                        name="specs[{{ $loop->index }}][name]"
                                                        value="{{ $spec->spec_name }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="specs[{{ $loop->index }}][value]"
                                                        class="form-control" value="{{ $spec->spec_value }}">
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm btn-destroy">Xóa</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="button" id="add-spec" class="btn btn-primary btn-sm">+ Thêm thông
                                    số</button>
                            </div>
                        </div>
                    </div>

                    <!-- Cột phải -->
                    <div class="col-lg-5">
                        <!-- Ảnh sản phẩm -->
                        <div class="card" style="border-width: 2px;">
                            <div class="card-header" style="background-color:aliceblue">
                                <h5 class="card-title mb-0">Ảnh sản phẩm</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <h5 class="fs-14 mb-1">Ảnh chính</h5>
                                    <div class="text-center">
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" id="product-img"
                                            class="img-fluid rounded mb-2" style="max-height:150px" />
                                        <input class="form-control" type="file" name="thumbnail">
                                    </div>
                                </div>

                                <div>
                                    <h5 class="fs-14 mb-1">Bộ sưu tập ảnh</h5>
                                    <input class="form-control" type="file" id="gallery" name="gallery[]" multiple>
                                    <div id="preview-container" class="d-flex flex-wrap mt-3 gap-2">
                                        <div class="row" id="gallery-wrapper">
                                            @foreach ($product->gallery ?? [] as $index => $image)
                                                <div class="col-md-3 mb-3 gallery-item" data-path="{{ $image }}">
                                                    <div class="position-relative">
                                                        <img src="{{ asset('storage/' . $image) }}"
                                                            class="img-fluid rounded border">
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 btn-remove-gallery">
                                                            &times;
                                                        </button>
                                                    </div>
                                                    {{-- input hidden để submit lên server --}}
                                                    <input type="hidden" name="old_gallery[]"
                                                        value="{{ $image }}">
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <pre>{{ var_dump($product->gallery) }}</pre> --}}
                        <!-- Xuất bản -->
                        <div class="card" style="border-width: 2px;">
                            <div class="card-header" style="background-color:aliceblue">
                                <h5 class="card-title mb-0">Xuất bản</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="choices-publish-status-input" class="form-label">Trạng thái</label>
                                    <select class="form-select" name="status">
                                        <option value="published"
                                            {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>
                                            Published</option>
                                        <option value="draft"
                                            {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Trạng thái hiển thị</label>
                                    <select class="form-select" name="visibility">
                                        <option value="public"
                                            {{ old('visibility', $product->visibility) == 'public' ? 'selected' : '' }}>
                                            Public</option>
                                        <option value="hidden"
                                            {{ old('visibility', $product->visibility) == 'hidden' ? 'selected' : '' }}>
                                            Hidden</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Danh mục -->
                        <div class="card" style="border-width: 2px;">
                            <div class="card-header" style="background-color:aliceblue">
                                <h5 class="card-title mb-0">Danh mục</h5>
                            </div>
                            <div class="card-body">
                                <select class="form-select" name="category_id">
                                    @foreach ($categories as $cate)
                                        <option value="{{ $cate->id }}"
                                            {{ old('category_id', $product->category_id) == $cate->id ? 'selected' : '' }}>
                                            {{ $cate->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mô tả chi tiết -->
                <div class="card" style="border-width: 2px;">
                    <div class="card-header" style="background-color:aliceblue">
                        <h5 class="card-title mb-0">Mô tả chi tiết</h5>
                    </div>
                    <div class="card-body">
                        <textarea name="description" id="description" class="form-control">
                                        {{ old('description', $product->description) }}
                                    </textarea>
                    </div>
                </div>
                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">Cập nhật</button>
                </div>
            </form>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        @once
        let myEditor;
        ClassicEditor.create(document.querySelector('#description'))
            .then(editor => {
                myEditor = editor;
            });

        document.querySelector('#product-form').addEventListener('submit', function() {
            document.querySelector('#description').value = myEditor.getData();
        });
        @endonce
    </script>
    <script>
        const input = document.getElementById("gallery");
        const dropzoneMock = document.getElementById("dropzone-mock");
        const previewContainer = document.getElementById("preview-container");

        // Khi click vùng dropzone -> mở file chọn
        dropzoneMock.addEventListener("click", () => input.click());

        // Render preview khi chọn file
        input.addEventListener("change", () => {
            previewContainer.innerHTML = ""; // clear cũ

            Array.from(input.files).forEach((file, index) => {
                if (!file.type.startsWith("image/")) return; // chỉ nhận ảnh

                const reader = new FileReader();
                reader.onload = (e) => {
                    const wrapper = document.createElement("div");
                    wrapper.classList.add("position-relative");
                    wrapper.style.width = "100px";
                    wrapper.style.height = "100px";

                    wrapper.innerHTML = `
                    <img src="${e.target.result}" class="img-fluid rounded" style="width:100%;height:100%;object-fit:cover;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-btn" data-index="${index}">×</button>
                `;

                    previewContainer.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        });

        // Xóa ảnh khỏi preview + input.files
        previewContainer.addEventListener("click", (e) => {
            if (e.target.classList.contains("remove-btn")) {
                const index = e.target.getAttribute("data-index");

                // Tạo lại FileList trừ file bị xóa
                const dt = new DataTransfer();
                Array.from(input.files).forEach((file, i) => {
                    if (i != index) dt.items.add(file);
                });
                input.files = dt.files;

                // Render lại preview
                input.dispatchEvent(new Event("change"));
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy số dòng specs có sẵn
            let specIndex = document.querySelectorAll('#spec-table tbody tr').length;

            // nút thêm
            document.getElementById('add-spec').addEventListener('click', function() {
                let tbody = document.querySelector('#spec-table tbody');
                let row = document.createElement('tr');

                row.innerHTML = `
            <td><input type="text" name="specs[${specIndex}][name]" class="form-control"></td>
            <td><input type="text" name="specs[${specIndex}][value]" class="form-control"></td>
            <td>
                <button type="button" class="btn btn-danger btn-sm btn-destroy">Xóa</button>
            </td>
        `;
                tbody.appendChild(row);
                specIndex++;
            });

            // nút xóa (event delegation)
            document.querySelector('#spec-table').addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-destroy')) {
                    e.target.closest('tr').remove();
                }
            });
            const wrapper = document.getElementById('gallery-wrapper');
            const preview = document.getElementById('new-gallery-preview');
            const galleryInput = document.getElementById('gallery');
            wrapper.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-remove-gallery')) {
                    let item = e.target.closest('.gallery-item');
                    let path = item.getAttribute('data-path');

                    // Thêm input để báo server biết ảnh nào cần xoá
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'remove_gallery[]';
                    input.value = path;
                    wrapper.appendChild(input);

                    // Ẩn khỏi UI
                    item.remove();
                }
            });
            // Preview ảnh mới
            galleryInput.addEventListener('change', function() {
                Array.from(this.files).forEach(file => {
                    let reader = new FileReader();
                    reader.onload = function(ev) {
                        let col = document.createElement('div');
                        col.classList.add('col-md-3', 'mb-3', 'gallery-item');
                        col.innerHTML = `
                    <div class="position-relative">
                        <img src="${ev.target.result}" class="img-fluid rounded border">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 btn-remove-new">&times;</button>
                    </div>
                `;
                        wrapper.appendChild(col);
                    };
                    reader.readAsDataURL(file);
                });
            });

            // Xoá ảnh mới khỏi preview
            wrapper.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-remove-new')) {
                    e.target.closest('.gallery-item').remove();
                }
            });
        });
    </script>
@endpush
