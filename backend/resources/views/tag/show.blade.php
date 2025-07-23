@extends('layouts.main')

@section('content')
    <!-- Main content -->
    <section class="content">

        @include('includes.tag.header')

        <div class="container-fluid">

            {{-- Header --}}

            @include('includes.tag.info-boxes')

            <!-- Main row -->
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $tag->title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                        <tr>
                                            <td class="font-weight-bold">ID</td>
                                            <td>{{ $tag->id }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Название</td>
                                            <td>{{ $tag->title }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Дата создания</td>
                                            <td>{{ $tag->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Дата последнего изменения</td>
                                            <td>{{ $tag->updated_at }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Дата удаления</td>
                                            <td>{{ $tag->deleted_at }}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <form class="card-footer" method="POST" action="{{ route('tag.destroy', $tag->id)}}">
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
                            <h3 class="card-title">Редактирование тега</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('tag.update', $tag->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Название тега</label>
                                    <input name="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1"
                                        placeholder="Введите название" value="{{ $tag->title }}">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
