@extends('layouts.main')

@section('content')
    <!-- Main content -->
    <section class="content">

        @include('includes.order.header')

        <div class="container-fluid">

            {{-- Header --}}

            @include('includes.order.info-boxes')

            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Все заказы</h3>

                            <div class="card-tools">
                                <form method="GET" action="{{ route('order.index') }}">
                                    <div class="input-group input-group-sm" style="width: 100%">
                                        {{-- <a href="{{ route('order.create') }}" type="submit" class="btn btn-primary form-control float-right">Добавить</a> --}}

                                        <div>
                                            <div>
                                                <select name="order_status"
                                                    class="form-control form-control-sm float-right">
                                                    <option selected disabled>Статус заказа</option>
                                                    <option value="">Все</option>
                                                    @foreach ($orderStatuses as $key => $status)
                                                        <option value="{{ $key }}"
                                                            {{ request('order_status') == $key ? 'selected' : '' }}>
                                                            {{ $status }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <input type="text" name="email"
                                            class="form-control float-right @error('email') is-invalid @enderror"
                                            placeholder="Email заказчика" value="{{ request()->get('email') }}">
                                        <input type="text" name="order_id"
                                            class="form-control float-right @error('order_id') is-invalid @enderror"
                                            placeholder="Номер заказа" value="{{ request()->get('order_id') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @error('order_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Номер заказа</th>
                                        <th>Заказчик</th>
                                        <th colspan="2" class="text-center">Контактные данные</th>
                                        <th>Цена</th>
                                        <th>Дата создания</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td><a href="{{ route('order.show', $order->id) }}">#{{ $order->id }}</a>
                                            </td>
                                            <td><a
                                                    href="{{ route('user.show', $order->user->id) }}">{{ $order->contact->email }}</a>
                                            </td>
                                            <td>{{ $order->contact->email }}</td>
                                            <td>{{ $order->contact->phone }}</td>
                                            @if ($order->total_price)
                                            <td>{{ number_format($order->total_price, 0, ',', ' ') }}₽</td>
                                            @else
                                            <td>X₽</td>
                                            @endif
                                            <td>{{ $order->created_at->translatedFormat('j F Yг.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                @if ($orders->count() == null)
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center" style="font-weight: bold;">Заказы с
                                                данными фильтрами не найдены</td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>

                        <!-- Пагинация -->
                        @if ($orders->hasPages())
                            <div class="card-footer clearfix">
                                <div class="float-right">
                                    {{ $orders->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
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
