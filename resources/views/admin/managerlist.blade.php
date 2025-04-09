@extends('layouts.app')

@section('css')
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('breadcrumb')
<div class="col-sm-6 text-left" >
     <h4 class="page-title">Manager</h4>
</div>
@endsection

@section('button')
<a href="#addnewManager" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Add New Manager</a>
        

@endsection

@section('content')
@include('includes.flash')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-striped table-hover table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            
                        <thead class="thead-dark">
                        <tr>
                            <th data-priority="1">ID</th>
                            <th data-priority="2">Manager Name</th>
                            <th data-priority="3">Email</th>
                            <th data-priority="6">Join Date</th>
                            <th data-priority="7">Status</th>
                            <th data-priority="8">Actions</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                        @if($managerList->count())
                        @foreach ($managerList as $manager)
                            <tr>
                                <td>{{ $manager->user->id }}</td>
                                <td>{{ $manager->user->name }}</td>
                                <td>{{ $manager->user->email }}</td>
                                <td>{{ $manager->join_date }}</td>
                                <td>{{ $manager->status }}</td>
                                <td>

                                    <a href="#editManager{{ $manager->id }}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                    <a href="#deleteManager{{ $manager->id }}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center text-danger"><strong>No Records Available</strong></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>

    @include('includes.add_manager')
    @include('includes.edit_manager')
    @include('includes.delete_manager')

@endsection

@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
     $.fn.dataTable.ext.errMode = 'none';
    $(document).ready(function () {
        // Check if already initialized
        if (!$.fn.DataTable.isDataTable('#datatable-buttons')) {
            var table = $('#datatable-buttons').DataTable({
                responsive: true
            });

            $('#managerSearch').on('keyup', function () {
                table.search(this.value).draw();
            });
        }
    });
</script>

@endsection