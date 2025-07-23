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
                            <h3 class="card-title">Редактирование товара</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('product.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Название</label>
                                    <input name="title" value="{{ old('title') ? old('title') : $product->title }}"
                                        type="title" class="form-control @error('title') is-invalid @enderror"
                                        id="exampleInputEmail1" placeholder="Введите название">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Краткое описание</label>
                                    <input name="description"
                                        value="{{ old('description') ? old('description') : $product->description }}"
                                        type="text" class="form-control @error('description') is-invalid @enderror"
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
                                        id="exampleInputPassword1" placeholder="Описание">{{ old('content') ? old('content') : $product->content }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Цена за шт.</label>
                                    <input name="price" value="{{ old('price') ? old('price') : $product->price }}"
                                        type="number" class="form-control @error('price') is-invalid @enderror"
                                        id="exampleInputPassword1" placeholder="Цена">
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Вес в кг</label>
                                    <input name="weight" value="{{ old('weight') ? old('weight') : $product->weight }}" type="number"
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
                                    <input name="count" value="{{ old('count') ? old('count') : $product->count }}"
                                        type="number" class="form-control @error('count') is-invalid @enderror"
                                        id="exampleInputPassword1" placeholder="Кол-во">
                                    @error('count')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="mt-2 mb-3">
                                            <label>Превью изображение:</label><br>
                                            <img src="{{ asset('storage/' . $product->previewImage) }}"
                                                alt="Текущее изображение" style="max-width: 200px; max-height: 200px;">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Заменить изображение</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input name="preview_image" type="file"
                                                        class="custom-file-input @error('preview_image') is-invalid @enderror"
                                                        id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Выберите новое
                                                        изображение</label>
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
                                    </div>
                                    @php
                                        // Создаем коллекцию из 4 элементов (существующие изображения + null для недостающих)
                                        $images = $product->images->take(3)->pad(3, null);
                                    @endphp

                                    @foreach ($images as $index => $image)
                                        <div class="col-3">
                                            @if ($image)
                                                <div class="mt-2 mb-3">
                                                    <label>Текущее изображение {{ $index + 1 }}:</label><br>
                                                    <img src="{{ asset('storage/' . $image->file_path) }}"
                                                        alt="Изображение {{ $index + 1 }}"
                                                        style="max-width: 200px; max-height: 200px;">
                                                    <input type="hidden" name="old_images[{{ $index }}]"
                                                        value="{{ $image->id }}">
                                                </div>
                                            @endif

                                            <div class="form-group">
                                                <label for="image_{{ $index }}">
                                                    @if ($image)
                                                        Заменить изображение
                                                    @else
                                                        Новое изображение
                                                    @endif
                                                </label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input name="images[{{ $index }}]" type="file"
                                                            class="custom-file-input @error('images.' . $index) is-invalid @enderror"
                                                            id="image_{{ $index }}">
                                                        <label class="custom-file-label" for="image_{{ $index }}">
                                                            Выберите файл
                                                        </label>
                                                    </div>
                                                    @error('images.' . $index)
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label>Категория</label>
                                    <select name="category_id"
                                        class="form-control select2 @error('category_id') is-invalid @enderror"
                                        style="width: 100%;">
                                        <option selected="selected" disabled>Выберите категорию</option>
                                        @foreach ($productRelations['categories'] as $category)
                                            <option {{ old('category_id') == $category->id ? ' selected' : '' }}
                                                @if (old('category_id')) {{ old('category_id') == $category->id ? ' selected' : '' }}
                                                @else
                                                    {{ $product->category->id == $category->id ? ' selected' : '' }} @endif
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
                                                @if ($product->tags) @foreach ($product->tags as $productTag)
                                                {{ $productTag->id == $tag->id ? ' selected' : '' }}
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
                                                @if ($product->colors) @foreach ($product->colors as $productColor)
                                                {{ $productColor->id == $color->id ? ' selected' : '' }}
                                            @endforeach @endif
                                                value="{{ $color->id }}">
                                                {{ $color->title }}</option>
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
                                <button type="submit" class="btn btn-primary">Сохранить</button>
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
