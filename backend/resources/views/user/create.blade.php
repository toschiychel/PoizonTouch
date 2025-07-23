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
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Регистрация нового пользователя</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Почта</label>
                                    <input name="email" value="{{ old('email') }}" type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="exampleInputEmail1" placeholder="Введите почту">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Пароль</label>
                                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1"
                                        placeholder="Пароль">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Подтверждение пароля</label>
                                    <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="exampleInputPassword1" placeholder="Пароль">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Имя</label>
                                    <input name="name" value="{{ old('name') }}" type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="exampleInputPassword1" placeholder="Имя">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Фамилия</label>
                                    <input name="surname" value="{{ old('surname') }}" type="text" class="form-control @error('surname') is-invalid @enderror"
                                        id="exampleInputPassword1" placeholder="Фамилия">
                                    @error('surname')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Номер телефона</label>
                                    <input name="phone" value="{{ old('phone') }}" type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="exampleInputPassword1" placeholder="Номер">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Адрес</label>
                                    <input name="address" value="{{ old('address') }}" type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="exampleInputPassword1" placeholder="Адрес">
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Select</label>
                                    <select class="form-control @error('role') is-invalid @enderror" name="role">
                                        <option disabled selected>Выберите роль</option>
                                        @foreach ($roles as $key => $value)
                                        <option {{ old('role') == $key ? ' selected' : '' }} value="{{ $key }}">{{ $value }}</option>
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
                                <button type="submit" class="btn btn-primary">Зарегистрировать</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- CreateSection --}}
            </div>
            <!-- /.row (main row) -->
        </div>
    </section>
@endsection
