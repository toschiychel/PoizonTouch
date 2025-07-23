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
                <div class="col-md-3">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Заказ #{{ $order->id }}</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 100%">
                                    {{-- <a href="{{ route('order.edit', $order->id) }}" type="submit" class="btn btn-primary form-control float-right">Редактировать</a> --}}
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">Цена заказа:</td>
                                        <td>{{ $order->totalPrice }}₽</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Статус:</td>
                                        <td>{{ $order->status }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Дата создания:</td>
                                        <td>{{ $order->createdAt }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <form class="card-footer" method="POST" action="{{ route('order.destroy', $order->id) }}">
                            @csrf
                            @method('delete')
                            {{-- <button type="submit" class="btn btn-danger w-100">Удалить</button> --}}
                        </form>
                        <!-- /.card-body -->
                    </div>
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Товары</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 100%">
                                    {{-- <a href="{{ route('order.edit', $order->id) }}" type="submit" class="btn btn-primary form-control float-right">Редактировать</a> --}}
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        @foreach ($order->positions as $positions)
                            <div class="card">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-head-fixed text-nowrap">
                                        <tbody>

                                            <tr>
                                                <td class="font-weight-bold">Превью:</td>
                                                <td><img style="height: 5rem"
                                                        src="{{ url('storage/' . $positions->previewImage) }}"></td>
                                                
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Название товара:</td>
                                                <td>{{ $positions->title }}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Цена за шт:</td>
                                                <td>{{ $positions->unitPrice ? $positions->unitPrice : 'X' }}₽</td>
                                                <td class="font-weight-bold">Кол-во:</td>
                                                <td>{{ $positions->quantity }}</td>
                                            </tr>
                                            @if ($positions->linkUrl)
                                                <tr>
                                                    <td class="font-weight-bold">Ссылка на товар:</td>
                                                    <td>{{ $positions->linkUrl }}</td>
                                                    <td class="font-weight-bold"></td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                        <form class="card-footer" method="POST" action="{{ route('order.destroy', $order->id) }}">
                            @csrf
                            @method('delete')
                            {{-- <button type="submit" class="btn btn-danger w-100">Удалить</button> --}}
                        </form>
                        <!-- /.card-body -->
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Удалить заказ</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0"></div>

                        <!-- Модальное окно подтверждения -->
                        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Подтверждение удаления</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Вы уверены, что хотите удалить этот заказ? Это действие нельзя отменить!
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Отмена</button>
                                        <button type="button" class="btn btn-danger" id="confirmDelete">Удалить</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form class="card-footer" method="POST" action="{{ route('order.destroy', $order->id) }}"
                            id="deleteForm">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-danger w-25" data-toggle="modal"
                                data-target="#deleteConfirmationModal">
                                Удалить
                            </button>
                        </form>
                    </div>

                    <!-- Скрипт для обработки подтверждения -->
                    <script>
                        document.getElementById('confirmDelete').addEventListener('click', function() {
                            document.getElementById('deleteForm').submit();
                        });
                    </script>
                </div>
                <div class="col-md-3">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Заказчик</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 100%">
                                    {{-- <a href="{{ route('order.edit', $order->id) }}" type="submit" class="btn btn-primary form-control float-right">Редактировать</a> --}}
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">Пользователь:</td>
                                        <td>{{ $order->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Почта:</td>
                                        <td>{{ $order->user->email }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <form class="card-footer" method="POST" action="{{ route('order.destroy', $order->id) }}">
                            @csrf
                            @method('delete')
                            {{-- <button type="submit" class="btn btn-danger w-100">Удалить</button> --}}
                        </form>
                        <!-- /.card-body -->
                    </div>
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Контактные данные</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 100%">
                                    {{-- <a href="{{ route('order.edit', $order->id) }}" type="submit" class="btn btn-primary form-control float-right">Редактировать</a> --}}
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">Адрес:</td>
                                        <td>{{ $order->contacts->address }}</td>
                                    </tr>
                                    <tr>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Имя:</td>
                                        <td>{{ $order->contacts->first_name }}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Фамилия:</td>
                                        <td>{{ $order->contacts->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Контактный номер:</td>
                                        <td>{{ $order->contacts->phone }}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Контактная почта:</td>
                                        <td>{{ $order->contacts->email }}</td>
                                    </tr>
                                    <tr>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Комментарий:</td>
                                        <td>{{ $order->contacts->note }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <form class="card-footer" method="POST" action="{{ route('order.destroy', $order->id) }}">
                            @csrf
                            @method('delete')
                            {{-- <button type="submit" class="btn btn-danger w-100">Удалить</button> --}}
                        </form>
                        <!-- /.card-body -->
                    </div>

                </div>
                
                <div class="col-md-4">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Данные доставки</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 100%">
                                    {{-- <a href="{{ route('order.edit', $order->id) }}" type="submit" class="btn btn-primary form-control float-right">Редактировать</a> --}}
                                </div>
                            </div>
                        </div>
                        @if ($order->deliveryInfo)
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">Транспортная:</td>
                                        <td>{{ $order->deliveryInfo->carrier }}</td>
                                        <td class="font-weight-bold">Последний статус:</td>
                                        <td>{{ $order->deliveryInfo->latestStatus }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Трек номер:</td>
                                        <td>{{ $order->deliveryInfo->trackingNumber }}</td>
                                        <td class="font-weight-bold">Последняя проверка:</td>
                                        <td>{{ $order->deliveryInfo->lastCheckedAt }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <form class="card-footer" method="POST" action="{{ route('order.destroy', $order->id) }}">
                            @csrf
                            @method('delete')
                            {{-- <button type="submit" class="btn btn-danger w-100">Удалить</button> --}}
                        </form>
                        <!-- /.card-body -->
                    </div>
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Путь посылки</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 100%">
                                    {{-- <a href="{{ route('order.edit', $order->id) }}" type="submit" class="btn btn-primary form-control float-right">Редактировать</a> --}}
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        @foreach ($order->deliveryInfo->events as $event)
                            <div class="card">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-head-fixed text-nowrap">
                                        <tbody>
                                            <tr>
                                                <td class="font-weight-bold">Статус:</td>
                                                <td>{{ $event->description }}</td>
                                                <td class="font-weight-bold">Локация:</td>
                                                <td>{{ $event->location }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Время события:</td>
                                                <td>{{ $event->happenedAt }}</td>
                                                <td class="font-weight-bold"></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                        <form class="card-footer" method="POST" action="{{ route('order.destroy', $order->id) }}">
                            @csrf
                            @method('delete')
                            {{-- <button type="submit" class="btn btn-danger w-100">Удалить</button> --}}
                        </form>
                        <!-- /.card-body -->
                        @endif
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Сменить статус заказа</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('order.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <label>Статус</label>
                                    <select name="status"
                                        class="form-control @error('status') is-invalid @enderror"
                                        style="width: 100%;">
                                        <option disabled {{ old('status', $order->status) ? '' : 'selected' }}>
                                            Выберите
                                            статус заказа</option>
                                        @foreach ($statuses as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ $order->status === $label ? ' selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
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
                    @if ($hasLinkPosition)
                        <div class="card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-footer">
                                <a href="{{ route('order.edit', $order->id) }}" type="submit"
                                    class="btn btn-success w-100">Посчитать цену</a>
                            </div>
                        </div>
                    @endif

                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Добавить доставку</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('order.delivery-status.store', $order->id) }}" method="POST">
                            @csrf
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Введите трек номер</label>
                                    <input name="trackingNumber" type="text"
                                        class="form-control @error('trackingNumber') is-invalid @enderror"
                                        id="exampleInputEmail1" placeholder="Трек номер" value="{{ $order->deliveryInfo->trackingNumber ?? null }}">
                                    @error('trackingNumber')
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
