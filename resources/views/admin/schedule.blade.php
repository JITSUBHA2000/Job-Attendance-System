@extends('layouts.app')

@section('css')
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('breadcrumb')
<div class="col-sm-6 text-left" >
     <h4 class="page-title">Schedule</h4>
</div>
@endsection

@section('button')
<a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Add New Schedule</a>
        

@endsection

@section('content')
@include('includes.flash')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable-buttons" class="table table-hover table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        
                                <thead class="thead-dark">
                                    <tr>
                                        <th data-priority="1">#</th>
                                        <th data-priority="2">Shift</th>
                                        <th data-priority="3">Time In</th>
                                        <th data-priority="4">Time Out</th>
                                        <th data-priority="5">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($allSchedule->count())
                                    @foreach($allSchedule as $schedule)
                                        <tr>
                                            <td> {{$schedule->id}} </td>
                                            <td> {{$schedule->slug}} </td>
                                            <td> {{$schedule->time_in}} </td>
                                            <td> {{$schedule->time_out}} </td>
                                            <td>

                                                <a href="#edit{{ $schedule->id }}" data-toggle="modal"
                                                    class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i>
                                                    </a>
                                                <a href="#delete{{ $schedule->id }}" data-toggle="modal"
                                                    class="btn btn-danger btn-sm delete btn-flat"><i
                                                        class='fa fa-trash'></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center text-danger"><strong>No Records Available</strong></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
@endsection

@foreach($allSchedule as $schedule)
    @include('includes.edit_schedule')
    @include('includes.delete_schedule')
@endforeach

@include('includes.add_schedule')

@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
     $.fn.dataTable.ext.errMode = 'none';
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable('#datatable-buttons')) {
            var table = $('#datatable-buttons').DataTable({
                responsive: true
            });

            $('#employeeSearch').on('keyup', function () {
                table.search(this.value).draw();
            });
        }
    });
</script>
@endsection