@extends('layouts.resident')
@section('title') Dashboard @endsection

@section('content')

<div class="container-fluid">
    {{-- <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $visitorsToday }}</h3>
                    <p>Visitors today</p>
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
                    <h3><sup style="font-size: 20px">{{ $visitorsPercentage }}%</sup></h3>
                    <p>Visitors today</p>
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
                    <h3>{{ $pendingValidation }}</h3>
                    <p>Pending Validation</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $rejectedVisitors }}</h3>
                    <p>Rejected Visitor</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div> --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $chartData['visitorsToday'] }}</h3>
                    <p>Visitors Today</p>
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
                    <h3>{{ $chartData['visitorsPercentage'] }}<sup style="font-size: 20px">%</sup></h3>
                    <p>Visitors Percentage</p>
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
                    <h3>{{ $chartData['pendingValidation'] }}</h3>
                    <p>Pending Validation</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $chartData['rejectedVisitors'] }}</h3>
                    <p>Rejected Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
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
        <!-- Chart -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Visitors Statistics</h3>
                </div>
                <div class="card-body">
                    <canvas id="visitorsChart"></canvas>
                </div>
            </div>
        </div>
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
    const visitorsToday = chartData.visitorsToday;
    const totalVisitors = chartData.totalVisitors;
    const visitorsPercentage = chartData.visitorsPercentage;
    const pendingValidation = chartData.pendingValidation;
    const rejectedVisitors = chartData.rejectedVisitors;

    // Create the chart using Chart.js
    const visitorsChart = new Chart(document.getElementById('visitorsChart'), {
        type: 'bar', // You can choose the chart type (e.g., 'bar', 'line', 'pie', etc.)
        data: {
            labels: ['Visitors Today', 'Total Visitors', 'Pending Validation', 'Rejected Visitors'],
            datasets: [{
                label: 'Visitors Data',
                data: [visitorsToday, totalVisitors, pendingValidation, rejectedVisitors],
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)'],
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

<script>
     const chartData = @json($chartData);
    console.log('Chart Data:', chartData);
</script>


@endsection
