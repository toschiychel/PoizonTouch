@extends('layouts.main')

@section('content')
    <!-- Main content -->
    <section class="content">

        @include('includes.color.header')

        <div class="container-fluid">

            {{-- Header --}}

            @include('includes.color.info-boxes')

            <!-- Main row -->
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $color->title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                        <tr>
                                            <td class="font-weight-bold">ID</td>
                                            <td>{{ $color->id }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Название</td>
                                            <td>{{ $color->title }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Цвет</td>
                                            <td><span class=""><i class="fas fa-square"
                                                style="color: {{ $color->hex }}"></i></span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Hex код</td>
                                            <td>{{ $color->hex }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Дата создания</td>
                                            <td>{{ $color->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Дата последнего изменения</td>
                                            <td>{{ $color->updated_at }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Дата удаления</td>
                                            <td>{{ $color->deleted_at }}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <form class="card-footer" method="POST" action="{{ route('color.destroy', $color->id)}}">
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
                            <h3 class="card-title">Редактирование цвета</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('color.update', $color->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Изменить название</label>
                                    <input name="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1"
                                        placeholder="Введите название" value="{{ $color->title }}">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Изменить цвет</label>
                                    <div class="input-group my-colorpicker2 colorpicker-element" data-colorpicker-id="2">
                                        <input name="hex" type="text" class="form-control" data-original-title=""
                                            title="" value="{{ $color->hex }}">
    
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square"
                                                    style="color: {{ $color->hex }}"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary w-100">Изменить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div>
    </section>
@endsection
