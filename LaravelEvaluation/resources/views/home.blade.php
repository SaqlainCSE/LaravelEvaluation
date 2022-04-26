@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Product List  (mosharaf111hossain@gmail.com)
                    <a href="/products/create" class="btn btn-warning btn-sm mgl-10px">Create</a>
                </div>

                <div class="card-body">

                    @include('partials.success_message')

                    <table class="table table-striped">
                        <tr>
                            <th>#ID</th>
                            <th>Thumnail</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Created At</th>

                            <th>Action</th>

                        </tr>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>
                                @if ($product->thumbnail)
                                    <img src="{{$product->thumbnail_path()}}" class="rounded-circle"
                                    style=" float:left; margin-right:15px; " alt="Thumbnail" width="60">
                                @endif
                               </td>
                                <td>{{$product->title}}</td>
                                <td>{!!$product->description!!}</td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->created_at->diffForHumans()}}</td>

                                <td>

                                    <a href="/products/{{$product->id}}" class="btn btn-danger btn-sm">Delete</a>
                                </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
