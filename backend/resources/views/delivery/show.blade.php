@extends('layouts.main')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            @include('includes.delivery.header')
            {{-- Header --}}

            <!-- Main row -->
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $delivery->title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                        <tr>
                                            <td class="font-weight-bold">ID</td>
                                            <td>{{ $delivery->id }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Название</td>
                                            <td>{{ $delivery->title }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Цена за кг</td>
                                            <td>{{ $delivery->price_per_kg }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Дата создания</td>
                                            <td>{{ $delivery->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Дата последнего изменения</td>
                                            <td>{{ $delivery->updated_at }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Дата удаления</td>
                                            <td>{{ $delivery->deleted_at }}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <form class="card-footer" method="POST" action="{{ route('delivery.destroy', $delivery->id)}}">
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
                            <h3 class="card-title">Редактирование доставки</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('delivery.update', $delivery->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Название доставки</label>
                                    <input name="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1"
                                        placeholder="Введите название" value="{{ $delivery->title }}">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                                                       <div class="card-body pb-0">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Цена за кг</label>
                                    <input name="price_per_kg" type="text"
                                        class="form-control @error('price_per_kg') is-invalid @enderror" id="exampleInputEmail1"
                                        placeholder="Введите название" value="{{ $delivery->price_per_kg }}">
                                    @error('price_per_kg')
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
