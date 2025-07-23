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
                            <h3 class="card-title font-weight-bold">Пользователь: {{ $product->title }}</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 100%">
                                    <a href="{{ route('product.edit', $product->id) }}" type="submit"
                                        class="btn btn-primary form-control float-right">Редактировать</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">ID</td>
                                        <td>{{ $product->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Название</td>
                                        <td>{{ $product->title }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Превью</td>
                                        <td><img style="width: 100px" src="{{ url('storage/' . $product->previewImage) }}" alt="preview"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Изображения</td>
                                        <td>
                                            @foreach ($product->images as $image)
                                            <img style="width: 100px" src="{{ url('storage/' . $image->file_path) }}" alt="preview">
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Цена(шт)</td>
                                        <td>{{ $product->price }}₽</td>
                                    </tr>
                                                                        <tr>
                                        <td class="font-weight-bold">Вес(кг)</td>
                                        <td>{{ $product->weight }}кг</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Краткое описание</td>
                                        <td>{{ $product->description }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Описание</td>
                                        <td>{{ $product->content }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold 
                                        @if($product->count == 0)
                                            text-danger
                                            @endif">Количество</td>
                                        <td>
                                            {{ $product->count }} шт.</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold 
                                        @if($product->publicationStatus == 'Не опубликован')
                                            text-danger font-weight-bold
                                            @endif">Статус публикации</td>
                                        <td>
                                            {{ $product->publicationStatus }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Категория</td>
                                        <td>{{ $product->category->title }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Теги</td>
                                        <td>
                                            @foreach ($product->tags as $tag)
                                                {{ $tag->title . ', '}}
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Цвета</td>
                                        <td>
                                            @foreach ($product->colors as $color)
                                            {{ $color->title . ', '}}
                                        @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Дата создания</td>
                                        <td>{{ $product->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Дата последнего обновления</td>
                                        <td>{{ $product->updated_at}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Дата удаления</td>
                                        <td>{{ $product->deleted_at}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Модальное окно подтверждения -->
                        <div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog"
                            aria-labelledby="deleteProductModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteProductModalLabel">Подтверждение удаления</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Вы уверены, что хотите удалить этот товар? Это действие нельзя отменить!
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Отмена</button>
                                        <button type="button" class="btn btn-danger"
                                            id="confirmProductDelete">Удалить</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Форма удаления -->
                        <form class="card-footer" method="POST" action="{{ route('product.destroy', $product->id) }}"
                            id="productDeleteForm">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-danger w-100" data-toggle="modal"
                                data-target="#deleteProductModal">
                                Удалить
                            </button>
                        </form>

                        <!-- Скрипт обработки -->
                        <script>
                            document.getElementById('confirmProductDelete').addEventListener('click', function() {
                                document.getElementById('productDeleteForm').submit();
                            });
                        </script>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div>
    </section>
@endsection
