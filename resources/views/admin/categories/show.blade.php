@extends('admin.layouts.app')
@section('title', 'Chi tiết danh mục')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lí danh mục</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Quản lí danh mục</a></li>
                        <li class="breadcrumb-item">Danh sách danh mục</li>
                        <li class="breadcrumb-item">Chi tiết danh mục</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Chi tiết danh mục : {{ $item->name }}</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-2">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div><!-- end card header -->

                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">Tên danh mục</th>
                                <td>{{ $item->name }}</td>
                            </tr>
                            <tr>
                                <th>Mô tả</th>
                                <td>{{ $item->description ?? 'Không có mô tả' }}</td>
                            </tr>
                            <tr>
                                <th>Ảnh</th>
                                <td>
                                    @if ($item->image)
                                        <img src="{{Storage::url($item->image) }}" alt="{{ $item->name }}" class="img-thumbnail"
                                            style="max-width: 200px;">
                                    @else
                                        <span class="text-muted">Chưa có ảnh</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{ $item->slug }}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái</th>
                                <td>
                                    @if ($item->status)
                                        <span class="badge bg-success">Kích hoạt</span>
                                    @else
                                        <span class="badge bg-secondary">Ẩn</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày tạo</th>
                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Ngày cập nhật</th>
                                <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->

@endsection
