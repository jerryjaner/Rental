@extends('layouts.app')
@section('content')


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Archive</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header w-100 d-flex justify-content-between align-items-center">
                        <h4 class="text-dark w-100 pt-2">Manage Archive</h4>
                    </div>
                    <div class="card-body" id="trashed">
                        <h1 class="text-center text-secondary my-5">Loading...</h1>
                    </div>
                </div>
            </div>
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

        trashed_data();

        function trashed_data(){
            $.ajax({
                url: '{{ route('archive.trashed') }}',
                method: 'GET',
                success: function(response) {
                $("#trashed").html(response);
                    $('#trashed_table').DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }

        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
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
                        url: '{{ route('archive.delete') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            console.log(response);
                            trashed_data();
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

        $(document).on('click', '.restore', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to restore this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Restore it!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('archive.restore') }}',
                        method: 'POST',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            console.log(response);
                            trashed_data();
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully Restored.',
                                showConfirmButton: false,
                                timer: 1700,
                            })
                        }
                    });
                }
            })
        });

    });
</script>
@endsection
