@extends('admin.master')
@section('content')
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Items Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Items Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Items</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              @if($count < 5)
                  <form action="{{route('item.store')}}" method="post" enctype="multipart/form-data">
                  @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Item">
                      </div>
                      <div class="form-group">
                          <label for="description">Description</label>
                          <textarea class="form-control" id="description" name="description" placeholder="Enter Description"></textarea>
                      </div>
                      <div class="form-group">
                        <label for="price">Price</label>
                        <input type="float" class="form-control" id="price" name="price" placeholder="Enter Price">
                      </div>
                      <div class="form-group">
                         <label>Select Category</label>
                         <select class="form-control" name="category_id" id="category_id">
                         @foreach($itemCategories as $c)
                           <option value="{{$c->id}}">{{$c->name}}</option>
                         @endforeach
                         </select>
                      </div>
                      <div class="form-group">
                         <label>Special</label>
                         <select class="form-control" name="isSpecial" id="isSpecial">                         
                           <option value="yes">Yes</option>
                           <option value="no">No</option>                         
                         </select>
                      </div>

                      <div class="form-group">
                          <label for="image">Choose Image</label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="form-control" id="image" name="image" placeholder="Choose Image">
                            </div>
                            <div class="input-group-append">
                              <span class="input-group-text" id="">Upload</span>
                            </div>
                          </div>
                      </div>
                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
               @else
                  <div class="card-body">
                    <p> Sorry, you cannot add more items. Please contact for premium subscription.</h4>
                  </div>
               @endif
            </div>
            <!-- /.card -->       </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
 @endsection

