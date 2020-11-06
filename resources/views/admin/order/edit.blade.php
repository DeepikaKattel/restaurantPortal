@extends('admin.master')
@section('content')
<div class="wrapper">
   <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Edit Order Details</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Edit Order Details</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-9">
                <form class="form-horizontal" action="{{route('order.update',$order->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                  <div class="form-group">
                     <label>Select Item</label>
                     <select class="form-control" name="item_id" id="item_id">
                     @foreach($items as $i)
                       <option value="{{$i->id}}">{{$i->name}}</option>
                     @endforeach
                     </select>
                  </div>
                  <div class="form-group row">
                    <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" id="quantity" name="quantity" value="{{old('quantity', $order->quantity)}}">
                    </div>
                  </div>
                  <div class="form-group row float-right">
                      <div class="offset-sm-2 col-sm-10">
                            <input type="button" class="btn btn-primary" value="Back" onclick="history.back()">
                      </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
             </div>
          </div>
        </div>
      </section>
   </div>
</div>
