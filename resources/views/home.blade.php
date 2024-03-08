@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Dashboard') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">
                                <canvas id="bar-chart" width="800" height="150"></canvas>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('bar-chart').getContext('2d');
        var data = @json($data);

        var labels = [];
        var paidCounts = [];
        var unpaidCounts = [];

        data.forEach(function(item) {
            // Convert month number to word
            var monthName = new Date(Date.UTC(2000, item.month - 1, 1)).toLocaleString('en-US', { month: 'long' });
            var label = monthName + ' ' + item.year;

            if (!labels.includes(label)) {
                labels.push(label);
                paidCounts.push(0);
                unpaidCounts.push(0);
            }

            if (item.status === 'Paid') {
                paidCounts[labels.indexOf(label)] = item.count;
            } else {
                unpaidCounts[labels.indexOf(label)] = item.count;
            }
        });

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Paid',
                    data: paidCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Unpaid',
                    data: unpaidCounts,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            // options: {
            //     scales: {
            //         yAxes: [{
            //             ticks: {
            //                 beginAtZero: true
            //             }
            //         }]
            //     }
            // }
        });
    </script>

@endsection
