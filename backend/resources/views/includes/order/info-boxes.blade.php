<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $header['count'] }}</h3>

          <p>Кол-во заказов</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('order.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $header['finishedOrdersProcent'] }}<sup style="font-size: 20px">%</sup></h3>

          <p>Процент выполненных заказов</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $header['the_largest'] ? $header['the_largest']->positions()->count() : null }}ед. товара</h3>

          <p>Самый крупные заказ</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ $header['the_largest'] ? route('order.show', $header['the_largest']->id) : '#'}}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $header['the_most_expensive'] ? $header['the_most_expensive']->total_price : null }}₽</h3>

          <p>Самый дорогой заказ</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="{{ $header['the_most_expensive'] ? route('order.show', $header['the_most_expensive']->id) : '#' }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>