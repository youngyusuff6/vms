@extends('layouts.security')
@section('title') Security Dashboard @endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Small boxes (Stat boxes) -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $chartData['totalVisitors'] }}</h3>
                    <p>Total Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $chartData['visitorsToday'] }}</h3>
                    <p>Visitors Today</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $chartData['visitorsRegisteredByMe'] }}</h3>
                    <p>Visitors Registered by Me</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Visitor Statistics</h3>
                </div>
                <div class="card-body">
                    <canvas id="visitorsChart"></canvas>
                </div>
            </div>
        </section>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
@endsection

@section('scripts')
<!-- Include Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get the chart data from the PHP variable and parse it as JSON
    const chartData = @json($chartData);

    // Access the individual data points
    const totalVisitors = chartData.totalVisitors;
    const visitorsToday = chartData.visitorsToday;
    const visitorsRegisteredByMe = chartData.visitorsRegisteredByMe;

    // Create the chart using Chart.js
    const visitorsChart = new Chart(document.getElementById('visitorsChart'), {
        type: 'bar', // You can choose the chart type (e.g., 'bar', 'line', 'pie', etc.)
        data: {
            labels: ['Total Visitors', 'Visitors Today', 'Visitors Registered by Me'],
            datasets: [{
                label: 'Visitors Data',
                data: [totalVisitors, visitorsToday, visitorsRegisteredByMe],
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
