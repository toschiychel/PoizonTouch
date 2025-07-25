<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $header['count'] }}</h3>

          <p>Кол-во пользователей</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('user.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{$header['activeUserPercent']}}%<sup style="font-size: 20px"></sup></h3>

          <p>Процент активных пользователей</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('user.index')}}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $header['newUsers'] }}</h3>

          <p>Новых пользователя за 30д</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('user.index')}}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $header['topSpendingUser'] ? $header['topSpendingUser']['name'] : null }}</h3>

          <p>Самые покупательный клиент</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="{{ $header['topSpendingUser'] ? route('user.show', $header['topSpendingUser']['id']) : '#'}}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>