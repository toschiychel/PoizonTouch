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
                            <h3 class="card-title">Все виды доставки</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Название</th>
                                        <th>Цена за кг</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deliveries as $delivery)
                                        <tr>
                                            <td>{{ $delivery->id }}</td>
                                            <td><a
                                                    href="{{ route('delivery.show', $delivery->id) }}">{{ $delivery->title }}</a>
                                            </td>
                                            <td>{{ $delivery->price_per_kg }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($deliveries->hasPages())
                            <div class="card-footer clearfix">
                                <div class="float-right">
                                    {{ $deliveries->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        @endif
                        <!-- /.card-body -->
                    </div>
                </div>

                {{-- CreateSection --}}

                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Добавление новой доставки</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('delivery.store') }}" method="POST">
                            @csrf
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Название доставки</label>
                                    <input name="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1"
                                        placeholder="Введите название">
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
                                        class="form-control @error('price_per_kg') is-invalid @enderror"
                                        id="exampleInputEmail1" placeholder="Введите название">
                                    @error('price_per_kg')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary w-100">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div>
    </section>
@endsection
