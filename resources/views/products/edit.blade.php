@extends('layouts.admin', ['title', 'Ubah Produk'])

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route('product.index') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ubah Produk</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Ubah Produk</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('product.save', $product->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="act" value="edit">
                    
                        <div class="form-group">
                            <label for="">Product Code</label>
                            <input type="text" class="form-control" name="product_code" value="{{ $product->product_code }}">
                        </div>
                        <div class="form-group">
                            <label for="">Product Name</label>
                            <input type="text" class="form-control" name="product_name" value="{{ $product->product_name }}">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category_id" id="category" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Stock</label>
                                    <input type="number" class="form-control" name="stock" value="{{ $product->stock }}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Price</label>
                                    <input type="number" class="form-control" name="price" value="{{ $product->price }}">
                                </div>
                            </div>
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fas fa-fw fa-paper-plane"></i> Ubah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection