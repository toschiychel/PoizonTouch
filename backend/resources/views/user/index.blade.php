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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Все пользователи</h3>

                            {{-- <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 100%">
                                    <a href="{{ route('user.create') }}" type="submit" class="btn btn-primary form-control float-right">Регистрация</a>
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Имя</th>
                                        <th>Почта</th>
                                        <th>Кол-во заказов</th>
                                        <th>Дата регистрации</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->orders->count() }}</td>
                                        <td>{{ $user->created_at->translatedFormat('j F Yг.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($users->hasPages())
                            <div class="card-footer clearfix">
                                <div class="float-right">
                                    {{ $users->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        @endif
                        </div>

                        <!-- /.card-body -->
                    </div>
                </div>

                {{-- CreateSection --}}
            </div>
            <!-- /.row (main row) -->
        </div>
    </section>
@endsection
