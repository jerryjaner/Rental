@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Family Table -->
<!-- Family Table -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {{-- <div class="card-header w-100 d-flex ">
                        <h4 class="text-dark pt-2" style="width:10%">All Records</h4>
                        <div class="text-center">
                            <div class="row">
                                <div class="col-xl-4">
                                    <input type="date" class="form-control" id="start_date" placeholder="Start Date">
                                </div>
                                <div class="col-xl-4">
                                    <input type="date" class="form-control" id="end_date" placeholder="End Date">
                                </div>
                                <div class="col-xl-4">
                                    <button id="filter" class="btn btn-primary btn-sm">Filter</button>
                                    <button id="reset" class="btn btn-success btn-sm">Refresh</button>
                                    <button id="print" class="btn btn-info btn-sm">Print</button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="card-header w-100 d-flex justify-content-space-between">
                        <h4 class="text-dark pt-2" style="width: 10%;">All Records</h4>
                        <div class="text-center d-flex justify-content-end align-items-center flex-grow-1">
                            <div class="row mx-0">
                                <div class="col-xl-4 px-1">
                                    <input type="date" class="form-control" id="start_date" placeholder="Start Date" required>
                                </div>
                                <div class="col-xl-4 px-1">
                                    <input type="date" class="form-control mr-1" id="end_date" placeholder="End Date" required>
                                </div>
                                <div class="col-xl-4 px-1 d-flex justify-content-end">
                                    <button id="filter" class="btn btn-primary btn-sm flex-fill mr-1">Filter</button>
                                    <button id="reset" class="btn btn-success btn-sm flex-fill mr-1">Refresh</button>
                                    <button id="print" class="btn btn-info btn-sm flex-fill">Print</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-container">

                            <div class="card-body" id="record">
                                <h1 class="text-center text-secondary my-5">Loading...</h1>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>

<script>
  document.getElementById("print").addEventListener("click", function() {
    var printContents = document.getElementById("record_table_wrapper").cloneNode(true);
    var originalContents = document.body.innerHTML;

    // Remove pagination, search bar, and data entries
    printContents.getElementsByClassName("dataTables_paginate")[0].style.display = "none";
    printContents.getElementsByClassName("dataTables_filter")[0].style.display = "none";
    printContents.getElementsByClassName("dataTables_info")[0].style.display = "none";
    printContents.getElementsByClassName("dataTables_length ")[0].style.display = "none";

    document.body.innerHTML = printContents.outerHTML;

    window.print();

    document.body.innerHTML = originalContents;
    location.reload();
});

</script>
<script>

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    getRecords();

    $('#filter').click(function () {
        getRecords();
    });

    $('#reset').click(function () {
        $('#start_date').val('');
        $('#end_date').val('');
        getRecords();
    });

    function getRecords() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();

        $.ajax({
            url: '{{ route('get.record') }}',
            method: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function (response) {
                $("#record").html(response);
                $('#record_table').DataTable({
                    order: [0, 'desc'],
                });

            }
        });
    }



});

</script>

@endsection
