@extends('layouts.main')

@section('content')
    <!-- Main content -->
    <section class="content">

        @include('includes.user.header')

        <div class="container-fluid">

            {{-- Header --}}

            @include('includes.user.info-boxes')

            <!-- Main row -->
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Пользователь: {{ $user->name }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">ID</td>
                                        <td>{{ $user->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Имя</td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Фамилия</td>
                                        <td>{{ $user->surname }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Email</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Phone</td>
                                        <td>{{ $user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Сумма заказов</td>
                                        <td>{{ $user->orders->totalPrice }}₽</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Роль</td>
                                        <td>{{ $user->role }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Адрес</td>
                                        <td>{{ $user->address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Дата регистрации</td>
                                        <td>{{ $user->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Дата последнего обновления</td>
                                        <td>{{ $user->updated_at }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Дата удаления</td>
                                        <td>{{ $user->deleted_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                        <!-- Кнопка удаления (вместо текущей формы) -->
                        <button type="button" class="btn btn-danger w-25" data-toggle="modal"
                            data-target="#deleteUserModal" data-user-id="{{ $user->id }}"
                            data-user-name="{{ $user->name }}">
                            Удалить
                        </button>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Заказы пользователя на сумму: {{ $user->orders->totalPrice }}₽</h3>

                        </div>
                    </div>
                    @foreach ($user->orders as $order)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Заказ: <a
                                        href="{{ route('order.show', $order->id) }}">#{{ $order->id }}</a></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-head-fixed text-nowrap">
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold">Цена</td>
                                            <td>{{ $order->total_price }}₽</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Статус</td>
                                            <td>{{ $order->status->label() }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    @endforeach
                </div>

                {{-- CreateSection --}}

                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Редактирование пользователя</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Имя пользователя</label>
                                    <input name="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1"
                                        placeholder="Введите название" value="{{ $user->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Фамилия</label>
                                    <input name="surname" type="text"
                                        class="form-control @error('surname') is-invalid @enderror" id="exampleInputEmail1"
                                        placeholder="Введите название" value="{{ $user->surname }}">
                                    @error('surname')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Адрес</label>
                                    <input name="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror" id="exampleInputEmail1"
                                        placeholder="Введите название" value="{{ $user->address }}">
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Роль</label>
                                    <select name="role" class="form-control @error('role') is-invalid @enderror"
                                        style="width: 100%;">
                                        <option disabled {{ old('role', $user->role) ? '' : 'selected' }}>Выберите
                                            роль пользователя</option>
                                        @foreach ($userRoles as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ $user->role === $label ? ' selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
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

    <!-- Модальное окно подтверждения -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle mr-2"></i>Подтверждение удаления</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Вы действительно хотите удалить пользователя <strong id="userName"></strong>? Это действие нельзя
                    отменить!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <form id="deleteForm" method="POST" action="{{ route('user.destroy', $user->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Да, удалить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Скрипт для инициализации модального окна -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#deleteUserModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const userId = button.data('user-id');
                const userName = button.data('user-name');

                const modal = $(this);
                modal.find('#userName').text(userName);
            });
        });
    </script>
@endsection
