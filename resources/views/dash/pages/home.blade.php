@extends('dash.layouts.app')
@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-stats">
                    <div class="card-stats-title">Orders</div>
                    <div class="card-stats-items">
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $orders_count }}</div>
                            <div class="card-stats-item-label">{{ trans('orders.new') }}</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $orders_count }}</div>
                            <div class="card-stats-item-label">{{ trans('orders.single') }}</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $orders_count }}</div>
                            <div class="card-stats-item-label">{{ trans('orders.completed') }}</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon bg-primary">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total {{ trans('orders.module_title') }}</h4>
                    </div>
                    <div class="card-body">
                        {{ $orders_count }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-chart">
                    <canvas id="balance-chart" height="80"></canvas>
                </div>
                <div class="card-icon bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Budget</h4>
                    </div>
                    <div class="card-body">
                        {{ $trips_count }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-chart">
                    <canvas id="sales-chart" height="80"></canvas>
                </div>
                <div class="card-icon bg-primary">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>{{ trans('deals.module_title') }}</h4>
                    </div>
                    <div class="card-body">
                        {{ $deals_count }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection