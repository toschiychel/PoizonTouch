@extends('layouts.main')

@section('content')
    <section class="content">

        @include('includes.order.header')

        <div class="container-fluid">

            @include('includes.order.info-boxes')

            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Оценка заказа #{{ $order->id }}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Оценка товаров</h3>
                        </div>
                        <form action="{{ route('order.position.update', $order->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            @foreach ($linkPositions as $index => $position)
                                <div class="card-body">
                                    <div>
                                        <input hidden name="linkPositions[{{ $index }}][id]"
                                            value="{{ old('id') ? old('id') : $position->id }}" type="text"
                                            class="form-control @error('id') is-invalid @enderror" id="exampleInputEmail1"
                                            placeholder="Введите название">
                                        @error('id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Название товара от пользователя</label>
                                        <input name="linkPositions[{{ $index }}][title]"
                                            value="{{ old('title') ? old('title') : $position->title }}" type="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            id="exampleInputEmail1" placeholder="Введите название">
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ссылка на товар</label>
                                        <input readonly name="linkPositions[{{ $index }}][link_url]"
                                            value="{{ old('link_url') ? old('link_url') : $position->linkUrl }}"
                                            type="title" class="form-control @error('link_url') is-invalid @enderror"
                                            id="exampleInputEmail1" placeholder="Ссылка">
                                        @error('link_url')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-0" for="weight_{{ $index }}">Вес в кг</label>
                                        <input name="linkPositions[{{ $index }}][weight]"
                                            value="{{ old('linkPositions.' . $index . '.weight') }}" type="number"
                                            step="0.01"
                                            class="form-control @error('linkPositions.' . $index . '.weight') is-invalid @enderror"
                                            id="weight_{{ $index }}" placeholder="кг">
                                        @error('linkPositions.' . $index . '.weight')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-0">
                                        <label for="cny_price_{{ $index }}">Укажите цену (¥) товара за 1 шт.</label>
                                        <input name="linkPositions[{{ $index }}][cny_price]"
                                            value="{{ old('linkPositions.' . $index . '.cny_price') }}" type="number"
                                            step="0.01"
                                            class="form-control @error('linkPositions.' . $index . '.cny_price') is-invalid @enderror"
                                            id="cny_price_{{ $index }}" placeholder="¥">
                                        @error('linkPositions.' . $index . '.cny_price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="commission_percent_{{ $index }}">Укажите комиссию в
                                                    процентах
                                                    %</label>
                                                <input name="linkPositions[{{ $index }}][commission_percent]"
                                                    value="{{ old("linkPositions.$index.commission_percent") }}"
                                                    type="text"
                                                    class="form-control @error("linkPositions.$index.commission_percent") is-invalid @enderror"
                                                    id="commission_percent_{{ $index }}"
                                                    data-target="commission_fixed_{{ $index }}"
                                                    oninput="handleCommissionInput(this)" placeholder="%">
                                                @error("linkPositions.$index.commission_percent")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="commission_fixed_{{ $index }}">Или фиксированную в
                                                    рублях</label>
                                                <input name="linkPositions[{{ $index }}][commission_fixed]"
                                                    value="{{ old("linkPositions.$index.commission_fixed") }}"
                                                    type="text"
                                                    class="form-control @error("linkPositions.$index.commission_fixed") is-invalid @enderror"
                                                    id="commission_fixed_{{ $index }}"
                                                    data-target="commission_percent_{{ $index }}"
                                                    oninput="handleCommissionInput(this)" placeholder="₽">
                                                @error("linkPositions.$index.commission_fixed")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Оценка всего заказа #{{ $order->id }}</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">Цена заказа:</td>
                                        <td>{{ $order->totalPrice ? $order->totalPrice : 'X' }}₽</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Статус:</td>
                                        <td>{{ $order->status }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Дата создания:</td>
                                        <td>{{ $order->createdAt }}</td>
                                    </tr>
                                    @if ($order->calculated)
                                        <tr>
                                            <td class="font-weight-bold text-success">Статус цены:</td>
                                            <td>Все товары посчитаны</td>
                                        </tr>
                                    @endif
                                    @if (!$order->calculated)
                                        <tr>
                                            <td class="font-weight-bold text-danger">Статус цены:</td>
                                            <td>Товары не посчитаны!</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="font-weight-bold"></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Товары</h3>
                        </div>
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
                                            </tr>
                                            @if ($positions->linkUrl)
                                                <tr>
                                                    <td class="font-weight-bold">Ссылка на товар:</td>
                                                    <td>{{ $positions->linkUrl }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="font-weight-bold">Цена за шт:</td>
                                                <td>{{ $positions->unitPrice ? $positions->unitPrice : 'X' }}₽</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Кол-во:</td>
                                                <td>{{ $positions->quantity }}</td>
                                            </tr>
                                            @if ($positions->isCalculated)
                                                <tr>
                                                    <td class="font-weight-bold text-success">Статус цены:</td>
                                                    <td>Цена посчитана</td>
                                                </tr>
                                            @endif
                                            @if (!$positions->isCalculated)
                                                <tr>
                                                    <td class="font-weight-bold text-danger">Статус цены:</td>
                                                    <td>Цена не посчитана</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <script>
        function handleCommissionInput(el) {
            const targetId = el.dataset.target;
            const target = document.getElementById(targetId);
            if (!target) return;

            // Если в поле есть хоть один символ — блокируем целевой инпут
            const hasValue = el.value.trim().length > 0;

            target.disabled = hasValue;
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-target]').forEach(input => {
                input.addEventListener('input', () => handleCommissionInput(input));
                handleCommissionInput(input); // инициализация при загрузке
            });
        });
    </script>
@endsection
