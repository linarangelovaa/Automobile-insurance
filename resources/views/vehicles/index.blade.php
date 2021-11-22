@extends('layouts.master')


@section('content')
    <h2 class="mb-4">All vehicles</h2>
    <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#exampleModal">
        Add new Vehicle
    </button>
    <table class="table table-bordered yajra-datatable data-table" id="vehicleTable">
        <thead>

            <tr>
                <th>ID</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Plate number</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>

        <tbody>

        </tbody>
    </table>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="vehicleForm" name="vehicleForm" class="form-horizontal">
                        <input type="hidden" name="vehicle_id" id="vehicle_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Brand</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="brand" name="brand" placeholder="Enter Brand"
                                    maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Model</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="model" name="model" placeholder="Enter Model"
                                    maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">PlateNumber</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="plate_number" name="plate_number"
                                    placeholder="Plate Number" " maxlength=" 50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Date</label>
                            <div class="col-sm-12">
                                <input type="date" class="form-control" id="date" name="date" placeholder="Enter Date"
                                    maxlength="50" required="">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id="saveBtn" name="saveBtn" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('vehicles.list') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'brand',
                        name: 'brand'
                    },
                    {
                        data: 'model',
                        name: 'model',
                    },
                    {
                        data: 'plate_number',
                        name: 'plate_number'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });



        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Save');

            $.ajax({
                data: $('#vehicleForm').serialize(),
                url: "{{ route('vehicles.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {

                    $('#vehicleForm').trigger("reset");
                    $('#exampleModal').modal('hide');
                    table.draw();

                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

        $(document).on('click', '.editVehicle', function() {
            var vehicle_id = $(this).data('id');
            $.get("{{ url('vehicles/') }}" + '/' + vehicle_id + '/edit', function(data) {
                $('#modelHeading').html("Edit Vehicle");
                $('#saveBtn').val("edit-vehicle");
                $('#vehicle_id').val(data.id);
                $('#brand').val(data.brand);
                $('#model').val(data.model);
                $('#plate_number').val(data.plate_number);
                $('#date').val(data.date);
                $('#exampleModal').modal('show');



            })
        });

        $('body').on('click', '.deleteVehicle', function() {

            var vehicle_id = $(this).data("id");

            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "{{ url('vehicles/delete') }}" + '/' + vehicle_id,
                success: function(data) {
                    table.draw();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });
    </script>


@endsection
