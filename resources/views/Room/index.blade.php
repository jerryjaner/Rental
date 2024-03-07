@extends('layouts.app')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Room</h1>
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
                        <h4 class="text-dark w-100 pt-2">Manage Room</h4>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#create_room">
                            Create
                       </button>
                    </div>
                    <div class="card-body" id="show_all_room_data">

                        <h1 class="text-center text-secondary my-5">Loading...</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





{{-- create --}}
<div class="modal fade" id="create_room" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-primary" id="exampleModalLabel">Add Room</h5>
        </div>
        <form action="{{ route('room.store') }}" method="POST" id="create_apartment_room" enctype="multipart/form-data">
            @csrf
            <div class="modal-body p-4 bg-light">

                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Room Number</label>
                        <input type="text" name="room_number"  class="form-control" placeholder="Room Number" >
                        <span class="text-danger error-text room_number_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Status</label>
                        <select name="room_status" class="form-select" id="">
                            <option value="">Select Status</option>
                            <option value="Available">Available</option>
                            <option value="Not Available">Not Available</option>
                        </select>
                        <span class="text-danger error-text room_status_error"></span>
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
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-primary" id="exampleModalLabel">Add New Apartmment Rental</h5>
        </div>
        <form action="{{ route('room.update') }}" method="POST" id="edit_data" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="edit_id" id="edit_id">
            <div class="modal-body p-4 bg-light">
                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Room Number</label>
                        <input type="text" name="room_number"  class="form-control" placeholder="Room Number" id="room_number">
                        <span class="text-danger error-text room_number_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg mb-3">
                        <label>Status</label>
                        <select name="room_status" class="form-select" id="room_status">
                            <option value="">Select Status</option>
                            <option value="Available">Available</option>
                            <option value="Not Available">Not Available</option>
                        </select>
                        <span class="text-danger error-text room_status_error"></span>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal" id="edit_close_modal">Close</button>
                <button type="submit"  id="edit_btnSubmit" class="btn btn-primary">Update</button>
            </div>
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

        getroomdata();

        function getroomdata(){
            $.ajax({
                url: '{{ route('room.fetch') }}',
                method: 'GET',
                success: function(response) {
                   $("#show_all_room_data").html(response);
                    $('#room').DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }

        $('#create_apartment_room').on('submit',function (e) {

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
                    //Before Sending The Form
                    $(form).find('span.error-text').text('')
                },
                success: function(response) {
                    if(response.code == 0)
                    {
                        $('#btnSubmit').removeAttr("disabled"); // removing disabled button
                        //The Error Message Will Append
                        $.each(response.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                        $('#btnSubmit').text('Submit');

                    }
                    else
                    {
                        $(form)[0].reset(); // TO REST FORM
                        $('#btnSubmit').removeAttr("disabled"); // removing disabled button
                        $('#btnSubmit').text('Submit');   //change the text to normal
                        getroomdata();
                        // SWEETALERT
                        Swal.fire({

                            icon: 'success',
                            title: 'Created Successfully',
                            showConfirmButton: false,
                            timer: 1700,
                            timerProgressBar: true,

                        });

                        $('#create_room').modal('hide'); // Close the modal
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
                        url: '{{ route('room.delete') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            console.log(response);
                            getroomdata();
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
            url: '{{ route('room.edit') }}',
            method: 'GET',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $("#edit_id").val(response.id);
                $("#room_number").val(response.room_number);
                $("#room_status").val(response.room_status);
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
                        getroomdata();
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

@endsection
