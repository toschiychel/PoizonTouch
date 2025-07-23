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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Добавление нового товара</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Название</label>
                                    <input name="title" value="{{ old('title') }}" type="title"
                                        class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1"
                                        placeholder="Введите название">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Краткое описание</label>
                                    <input name="description" value="{{ old('description') }}" type="text"
                                        class="form-control @error('description') is-invalid @enderror"
                                        id="exampleInputPassword1" placeholder="Краткое описание">
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Описание</label>
                                    <textarea name="content" type="text" class="form-control @error('content') is-invalid @enderror"
                                        id="exampleInputPassword1" placeholder="Описание">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Цена за шт.</label>
                                    <input name="price" value="{{ old('price') }}" type="number"
                                        class="form-control @error('price') is-invalid @enderror" id="exampleInputPassword1"
                                        placeholder="Цена">
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Вес в кг</label>
                                    <input name="weight" value="{{ old('weight') }}" type="number"
                                        class="form-control @error('weight') is-invalid @enderror"
                                        id="exampleInputPassword1" step="0.1" placeholder="Цена">
                                    @error('weight')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Количество товара</label>
                                    <input name="count" value="{{ old('count') }}" type="number"
                                        class="form-control @error('count') is-invalid @enderror" id="exampleInputPassword1"
                                        placeholder="Кол-во">
                                    @error('count')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Превью изображение</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="preview_image" type="file"
                                                class="custom-file-input @error('preview_image') is-invalid @enderror"
                                                id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Выберите файл</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Загрузить</span>
                                        </div>
                                        @error('preview_image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Изображение 1</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="images[]" type="file"
                                                class="custom-file-input @error('preview_image') is-invalid @enderror"
                                                id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Выберите файл</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Загрузить</span>
                                        </div>
                                        @error('preview_image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Изображение 2</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="images[]" type="file"
                                                class="custom-file-input @error('preview_image') is-invalid @enderror"
                                                id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Выберите файл</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Загрузить</span>
                                        </div>
                                        @error('preview_image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Изображение 3</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="images[]" type="file"
                                                class="custom-file-input @error('preview_image') is-invalid @enderror"
                                                id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Выберите файл</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Загрузить</span>
                                        </div>
                                        @error('preview_image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Категория</label>
                                    <select name="category_id"
                                        class="form-control select2 @error('category_id') is-invalid @enderror"
                                        style="width: 100%;">
                                        <option selected="selected" disabled>Выберите категорию</option>
                                        @foreach ($productRelations['categories'] as $category)
                                            <option {{ old('category_id') == $category->id ? ' selected' : '' }}
                                                value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Выберите теги</label>
                                    <select name="tags[]" class="tags  @error('tags') is-invalid @enderror"
                                        multiple="multiple" data-placeholder="Выберите теги" style="width: 100%;">
                                        @foreach ($productRelations['tags'] as $tag)
                                            <option
                                                @if (old('tags')) @foreach (old('tags') as $oldTagId)
                                                {{ $oldTagId == $tag->id ? ' selected' : '' }}
                                            @endforeach @endif
                                                value="{{ $tag->id }}">
                                                {{ $tag->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('tags')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Выберите цвета</label>
                                    <select name="colors[]" class="colors  @error('colors') is-invalid @enderror"
                                        multiple="multiple" data-placeholder="Выберите цвета" style="width: 100%;">
                                        @foreach ($productRelations['colors'] as $color)
                                            <option
                                                @if (old('colors')) @foreach (old('colors') as $oldColorId)
                                            {{ $oldColorId == $color->id ? ' selected' : '' }}
                                                @endforeach @endif
                                                value="{{ $color->id }}">
                                                {{ $color->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('colors')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input type="hidden" name="is_published" value="0">
                                    <input name="is_published" type="checkbox" value="1"
                                        class="form-check-input @error('is_published') is-invalid @enderror"
                                        id="exampleCheck1"
                                        {{ old('is_published', $model->is_published ?? 0) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">Сразу опубликовать</label>
                                    @error('is_published')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Добавить</button>
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
