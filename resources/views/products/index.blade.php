@extends('layouts.admin', ['title', 'Category | Project 1'])

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">List Product</li>
    </ol>
</nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title">List Product</h5>
                        </div>
                        <div class="col-md-6">
                            {{-- <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm float-right">
                                <i class="fas fa-plus"></i> Add
                            </a> --}}
                            <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="row">
                        <div class="col-md">
                            <form action="#" method="GET" class="form-inline my-2 my-lg-0 float-right">
                                <input class="form-control mr-sm-2" type="text" name="q" value="" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Product Name</td>
                                    <td>Category</td>
                                    <td>Stock</td>
                                    <td>Price</td>
                                    <td>Publish</td>
                                    <td>Created at</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->category->category_name }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ 'Rp. ' . number_format($product->price) }}</td>
                                        <td>
                                            @if ($product->publish == 1)
                                                <span class="badge badge-success">Publish</span>
                                            @elseif($product->publish == 0)
                                                <span class="badge badge-dark">Not Publish</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-circle btn-sm btn-warning">
                                                <i class="fas fa-fw fa-pencil-alt"></i>
                                            </a>
                                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-circle btn-sm btn-info">
                                                <i class="far fa-fw fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- {{ $items->appends($request)->links() }} --}}
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="{{ route('product.store') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="act" value="add">
                        <div class="form-group">
                            <label for="">Product Code</label>
                            <input type="text" class="form-control" name="product_code">
                        </div>
                        <div class="form-group">
                            <label for="">Product Name</label>
                            <input type="text" class="form-control" name="product_name">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category_id" id="category" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Stock</label>
                                    <input type="number" class="form-control" name="stock">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Price</label>
                                    <input type="number" class="form-control" name="price">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
@endsection