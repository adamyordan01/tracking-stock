@extends('layouts.admin', ['title', 'Barang | BPN Langsa'])

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Log Stock</li>
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
                            <h5 class="card-title">{{ $product->product_name }} | Stock Log</h5>
                        </div>
                        {{-- <div class="col-md-6">
                            <a href="{{ route('item.create') }}" class="btn btn-primary btn-sm float-right">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        </div> --}}
                        {{-- <a href="{{ route('product.print', $product->id) }}" target="_blank" class="btn btn-sm btn-primary float-right">
                            <i class="fas fa-fw fa-print"></i> Cetak
                        </a> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Product Name</td>
                                    <td>Stock</td>
                                    <td>Description</td>
                                    <td>By</td>
                                    <td>Created at</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockLog as $log)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $log->product->product_name }}
                                        </td>
                                        <td>
                                            {{ $log->stock }}
                                        </td>
                                        <td>
                                            {{ $log->description }}
                                        </td>
                                        <td>
                                            {{ $log->user->name }}
                                        </td>
                                        <td>
                                            {{ $log->created_at->format('d-m-Y h:i:s') }}
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
    </div>
@endsection