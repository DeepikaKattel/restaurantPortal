@extends('admin.master')
@section('content')
<div class="wrapper">
   <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Categories</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Categories</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Table showing different categories</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>S.N.</th>
                      <th>Name</th>
                      <th>Image</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $c)
                       <tr>
                           <td>{{$loop->iteration}}</td>
                           <td>{{$c->name}}</td>
                           <td><img src="{{asset("$c->image")}}" style="height:30px;width: 50px;"></td>
                           <td id="none">
                               <a href="{{route('categories.edit',$c->id)}}"><i class="fa fa-lg fa-edit"></i></a>
                               @method('DELETE')
                               <a onclick="return confirm('Do you want to delete')" href="{{route('c.destroy',$c->id)}}"><i class="fa fa-lg fa-minus-circle" style="color:red"></i></a>
                           </td>
                       </tr>
                   @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>S.N.</th>
                      <th>Name</th>
                      <th>Image</th>
                      <th>Action</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
  </div>
 @endsection


