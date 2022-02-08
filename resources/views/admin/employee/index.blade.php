@extends('layouts.admin_dashboard.main')
@section('title')
   Employees
@endsection
@push('style')
<link rel="stylesheet" href="{{asset('/layoutfiles/assets/css/jquery.dataTables.min.css')}}">
@endpush
@section('content')

<div class="content-wrapper">

       <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Employee</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employee</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  <div class="content">
  <div class="container-fluid">
  <div class="row">
  <div class="col-md-12">
  <br>
  <div class="card">
  <div class="card-header card-header-primary">
  <h4 class="card-title ">EMPLOYEES</h4>
  </div>
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="employee-table">
  <thead class=" text-primary">
  <th>DESIGNATION</th>
  <th>NAME</th>
  <th>EMAIL</th>
  <th>PHOTO</th>
  <th>ACTION</th>
  </thead>
</table>
  </div>
  </div>
  </div>
  </div>
</div>
</div>
</div>

</div>


<form id="edit-form" method="POST" action="">
@csrf
{{ method_field('DELETE') }}
</form>
          
  
@push('script')
<script src="{{asset('/layoutfiles/assets/js/jquery.dataTables.min.js')}}"></script>

<script>
$(function() {
    $('#employee-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('employee_data') !!}',
        columns: [
            { data: 'MyDesignation', name: 'MyDesignation.designation'},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'photo', name: 'photo' , render: function( data, type, full, meta ) {
                        return "<img src=\"/storage/" + data + "\" height=\"50\"/>";
                    }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false}
          
        ]
    });
    $('body').on('click','.deleting-btn',function(event){
      event.preventDefault();
      if (confirm("Do You Want To Delete ??")) {
        var url = $(this).data('url');
      $("#edit-form").attr('action', url).submit();
    };
      
    });
  });

</script>
@endpush

@endsection

