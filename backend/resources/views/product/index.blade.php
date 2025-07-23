@extends('layouts.main')

@section('content')
    <!-- Main content -->
    <section class="content">

        @include('includes.product.header')

        <div class="container-fluid">

            {{-- Header --}}

            @include('includes.product.info-boxes')

            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Все товары</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 100%">
                                    <a href="{{ route('product.create') }}" type="submit" class="btn btn-primary form-control float-right">Добавить</a>
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
                                        <th>Превью</th>
                                        <th>Описание</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td><a href="{{ route('product.show', $product->id) }}">{{ $product->title }}</a></td>
                                        <td><img style="height: 5rem" src="{{ url('storage/' . $product->preview_image) }}" alt="{{ 'preview_' . $product->title }}"></td>
                                        <td>{{ $product->description }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($products->hasPages())
                        <div class="card-footer clearfix">
                            <div class="float-right">
                                {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    @endif
                        <!-- /.card-body -->
                    </div>
                </div>

                {{-- CreateSection --}}
            </div>
            <!-- /.row (main row) -->
        </div>
    </section>
@endsection
