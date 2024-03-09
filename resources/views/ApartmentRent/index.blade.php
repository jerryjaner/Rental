@extends('layouts.app')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Apartment</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Family Table -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header w-100 d-flex justify-content-between align-items-center">
                        <h4 class="text-dark w-100 pt-2">Manage Apartment</h4>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#create">
                            Create
                       </button>
                    </div>
                    <div class="card-body" id="show_all_apartment_data">

                        <h1 class="text-center text-secondary my-5">Loading...</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- create --}}
<div class="modal fade" id="create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-primary" id="exampleModalLabel">Add New Apartmment Rental</h5>
        </div>
        <form action="{{ route('apartment.store') }}" method="POST" id="create_rental" enctype="multipart/form-data">
            @csrf
            <div class="modal-body p-4 bg-light">

                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Tenant FullName</label>
                        <input type="text" name="tenant_name"  class="form-control" placeholder="Tenant FullName" >
                        <span class="text-danger error-text tenant_name_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Date</label>
                        <input type="date" name="date"  class="form-control" placeholder="Date" >
                        <span class="text-danger error-text date_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Room Number</label>
                        {{-- <select name="room_number" id="" class="form-select">
                            <option value="">--Select an option--</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->room_number }}">{{ $room->room_number }}</option>
                            @endforeach
                        </select> --}}
                        <select name="room_number" id="room_number" class="form-select">
                            <option value="">--Select an option--</option>
                        </select>

                        <span class="text-danger error-text room_number_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Rent Fee</label>
                        <input type="number" name="rent_fee" min="0" class="form-control" placeholder="Rent Fee" >
                        <span class="text-danger error-text rent_fee_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Tenant Status</label>
                        <input type="text" name="status"  class="form-control" placeholder="Tenant Status" >
                        <span class="text-danger error-text status_error"></span>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-lg mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select" id="txt-type">
                            <option value="">Select Status</option>
                            <option value="Paid">Paid</option>
                            <option value="Unpaid">UnPaid</option>
                        </select>
                        <span class="text-danger error-text status_error"></span>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-lg mb-3">
                        <div id="input-group-container" class="mb-3">
                            <div class="input-group mb-3">
                                <table class="table table-bordered" id="repeater">
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <b> Create New Contract</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td> <input type="date" class="form-control" placeholder="Start Date" name="inputs[0][renew_start_date]"></td>
                                        <td> <input type="date" class="form-control" placeholder="End Date" name="inputs[0][renew_end_date]"></td>

                                        <td> <select class="form-select" aria-label="status" name="inputs[0][status]">
                                                <option selected>Payment Status</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Unpaid">Unpaid</option>
                                            </select>
                                        </td>
                                        <td><button type="button" name="add" id="add" class="btn btn-success" >Add More</button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal" id="close_modal">Close</button>
                <button type="submit"  id="btnSubmit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
    </div>
</div>


{{-- edit --}}
<div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-primary" id="exampleModalLabel">Update Apartmment Rental</h5>
        </div>
        <form action="{{ route('apartment.update') }}" method="POST" id="edit_data" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="edit_id" id="edit_id">
            <div class="modal-body p-4 bg-light">
                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Tenant FullName</label>
                        <input type="text" name="tenant_name"  class="form-control" placeholder="Tenant FullName"  id="tenant_name">
                        <span class="text-danger error-text tenant_name_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Date</label>
                        <input type="date" name="date"  class="form-control" placeholder="Date" id="date">
                        <span class="text-danger error-text date_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Room Number</label>
                        <input type="text" name="room_number"  class="form-control" placeholder="Room Number" id="tenant_room_number" readonly>
                        <span class="text-danger error-text room_number_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Rent Fee</label>
                        <input type="number" name="rent_fee" min="0" class="form-control" placeholder="Rent Fee" id="rent_fee">
                        <span class="text-danger error-text rent_fee_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Tenant Status</label>
                        <input type="text" name="status"  class="form-control" placeholder="Tenant Status" id="status">
                        <span class="text-danger error-text status_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg mb-3">
                        <div id="input-group-container" class="mb-3">
                            <div class="input-group mb-3">
                                <table class="table table-bordered" id="repeater">
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <b>Contract</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>


                                    </tr>
                                    <tbody id="data">
                                        <!-- Table rows will be populated dynamically via AJAX -->

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg mb-3">
                        <div id="input-group-container" class="mb-3">
                            <div class="input-group mb-3">
                                <table class="table table-bordered" id="repeater1">
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <b> Create New Contract</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td> <input type="date" class="form-control" placeholder="Start Date" name="inputs[0][renew_start_date]"></td>
                                        <td> <input type="date" class="form-control" placeholder="End Date" name="inputs[0][renew_end_date]"></td>
                                        {{-- <td> <input type="text" class="form-control" placeholder="Status" name="inputs[0][status]"></td> --}}

                                        <td> <select class="form-select" aria-label="status" name="inputs[0][status]">
                                                <option selected>Payment Status</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Unpaid">Unpaid</option>
                                            </select>
                                       </td>
                                        <td><button type="button" name="add1" id="add1" class="btn btn-success" >Add More</button></td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal" id="edit_close_modal">Close</button>
                <button type="submit"  id="edit_btnSubmit" class="btn btn-primary">Update</button>
            </div>
        </form>
      </div>
    </div>
</div>


<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>

<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        function populateRoomDropdown() {
            $.ajax({
                url: "{{ route('get.available.rooms') }}",
                type: 'GET',
                success: function(response) {
                    $('#room_number').empty();
                    $('#room_number').append('<option value="">--Select an option--</option>');
                    $.each(response, function(index, room) {
                        $('#room_number').append('<option value="' + room.room_number + '">' + room.room_number + '</option>');
                    });
                }
            });
        }

        // Call the function to populate room dropdown when modal is shown
        $('#create').on('shown.bs.modal', function () {
            populateRoomDropdown();
        });

        // Prevent form submission when an option is selected from the dropdown
        $('#room_number').on('change', function(event) {
            event.preventDefault(); // Prevent default form submission
            // You can perform any additional logic here if needed
        });





        getdata();

            function getdata(){
                $.ajax({
                    url: '{{ route('apartment.fetch') }}',
                    method: 'GET',
                    success: function(response) {
                    $("#show_all_apartment_data").html(response);
                        $('#sample1').DataTable({
                            order: [0, 'desc']
                        });
                    }
                });
            }

            $('#create_rental').on('submit',function (e) {

                e.preventDefault();
                $("#btnSubmit").text('Submitting. . .');
                $('#btnSubmit').attr("disabled", true);

                var form = this; //FORM
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: "json",
                    contentType:false,
                    beforeSend: function(){
                        $(form).find('span.error-text').text('')
                    },
                    success: function(response) {
                        if(response.code == 0)
                        {
                            $('#btnSubmit').removeAttr("disabled");

                            $.each(response.error, function(prefix, val){
                                $(form).find('span.'+prefix+'_error').text(val[0]);
                            });
                            $('#btnSubmit').text('Submit');

                        }
                        else
                        {
                            $(form)[0].reset();
                            $('#btnSubmit').removeAttr("disabled");
                            $('#btnSubmit').text('Submit');
                            $('#room_number').html(response.html);
                            getdata();
                            Swal.fire({

                                icon: 'success',
                                title: 'Created Successfully',
                                showConfirmButton: false,
                                timer: 1700,
                                timerProgressBar: true,

                            });

                            $('#create').modal('hide');
                        }
                        $('#close_modal').on('click', function () {
                            $(form)[0].reset();
                            $(form).find('span.error-text').text('');
                        });

                    }
                });
            });

        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            var reader = new FileReader();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('apartment.delete') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            console.log(response);
                            getdata();
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted Successfully.',
                                showConfirmButton: false,
                                timer: 1700,
                            })
                        }
                    });
                }
            })
        });

        $(document).on('click', '.edit', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ route('apartment.edit') }}',
                method: 'GET',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#edit_id").val(response.id);
                    $("#tenant_name").val(response.tenant_name);
                    $("#date").val(response.date);
                    $("#tenant_room_number").val(response.room_number);
                    $("#rent_fee").val(response.rent_fee);
                    $("#status").val(response.status);

                    $("#data").empty();

                    response.renewcontracts.forEach(function(data) {
                        var dataHtml = '<tr>' +
                            '<td> <input type="text" class="form-control" placeholder="Start Date" name="inputs[0][renew_start_date]" value="' + data.renew_start_date + '" readonly></td>' +
                            '<td> <input type="text" class="form-control" placeholder="End" name="inputs[0][renew_end_date]" value="' + data.renew_end_date + '" readonly></td>' +
                            '<td> <input type="text" class="form-control" placeholder="End" name="inputs[0][status]" value="' + data.status + '" readonly></td>' +
                            '</tr>';

                        $("#data").append(dataHtml);
                    });

                }

            });
        });

        $("#edit_data").on('submit', function (e) {
            e.preventDefault();
            $("#edit_btnSubmit").text('Updating . . . ');
            $('#edit_btnSubmit').attr("disabled", true);
            var form = this;

            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: "json",
                contentType:false,
                beforeSend: function(){
                   $(form).find('span.error-text').text('');
                },
                success: function (response) {

                    if(response.code == 0){
                        $('#edit_btnSubmit').removeAttr("disabled");

                        $.each(response.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });

                        $("#edit_btnSubmit").text('Update');

                    }
                    else{

                        $(form)[0].reset();
                        $('#edit_btnSubmit').removeAttr("disabled");
                        $('#edit_btnSubmit').text('Update');
                        getdata();
                        $("#edit").modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Updated Successfully',
                            showConfirmButton: false,
                            timer: 1700,
                            timerProgressBar: true,

                        })

                    }

                    $('#edit_close_modal').on('click', function () {
                        $(form)[0].reset();
                        $(form).find('span.error-text').text('');
                    });


                }
            });
        });

    });
</script>

<script>
    var i = 0;
    $("#add").click(function(){
        ++i;

        $('#repeater').append(

            `<tr>
                <td> <input type="date" class="form-control" placeholder="Start Date" name="inputs[`+i+`][renew_start_date]"></td>
                <td> <input type="date" class="form-control" placeholder="End Date " name="inputs[`+i+`][renew_end_date]"></td>
                <td> <select class="form-select" aria-label="Status" name="inputs[`+i+`][status]">
                    <option selected>Payment Status</option>
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-table-row">Remove</button>
                 </td>
             </tr>`);


    });

   $(document).on('click', '.remove-table-row', function(){
        $(this).parents('tr').remove();
   });
</script>

<script>
    var i = 0;
    $("#add1").click(function(){
        ++i;

        $('#repeater1').append(

            `<tr>
                <td> <input type="date" class="form-control" placeholder="Start Date" name="inputs[`+i+`][renew_start_date]"></td>
                <td> <input type="date" class="form-control" placeholder="End Date " name="inputs[`+i+`][renew_end_date]"></td>
                <td> <select class="form-select" aria-label="Status" name="inputs[`+i+`][status]">
                    <option selected>Payment Status</option>
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-table-row1">Remove</button>
                 </td>
             </tr>`);


    });

   $(document).on('click', '.remove-table-row1', function(){
        $(this).parents('tr').remove();
   });

</script>

@endsection
