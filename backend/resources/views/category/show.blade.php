@extends('layouts.main')

@section('content')
    <!-- Main content -->
    <section class="content">

        @include('includes.category.header')

        <div class="container-fluid">

            {{-- Header --}}

            @include('includes.category.info-boxes')

            <!-- Main row -->
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $category->title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                        <tr>
                                            <td class="font-weight-bold">ID</td>
                                            <td>{{ $category->id }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Название</td>
                                            <td>{{ $category->title }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Большое превью</td>
                                            <td><img class="w-25" src="{{ $category->bigPreviewImageUrl }}" alt=""></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Маленько превью</td>
                                            <td><img class="w-25" src="{{ $category->smallPreviewImageUrl }}" alt=""></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Дата создания</td>
                                            <td>{{ $category->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Дата последнего обновления</td>
                                            <td>{{ $category->updated_at }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Дата удаления</td>
                                            <td>{{ $category->deleted_at }}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <form class="card-footer" method="POST" action="{{ route('category.destroy', $category->id)}}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger w-100">Удалить</button>
                        </form>
                        <!-- /.card-body -->
                    </div>
                </div>

                {{-- CreateSection --}}

                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Редактирование категории</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Название категории</label>
                                    <input name="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1"
                                        placeholder="Введите название" value="{{ $category->title }}">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Обновить превью 400x500</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="preview_small_image" type="file"
                                                class="custom-file-input @error('preview_small_image') is-invalid @enderror"
                                                id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Выберите файл</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Загрузить</span>
                                        </div>
                                        @error('preview_small_image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Обновить превью 800x700</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="preview_big_image" type="file"
                                                class="custom-file-input @error('preview_big_image') is-invalid @enderror"
                                                id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Выберите файл</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Загрузить</span>
                                        </div>
                                        @error('preview_big_image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary w-100">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div>
    </section>
@endsection
