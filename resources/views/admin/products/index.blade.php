@extends('layouts.sneat_master')

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-md-12 d-flex flex-row-reverse ">
            @if ($message = Session::get('success'))
                <div class="bs-toast toast fade show bg-success float-right" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="toast-header">
                        <i class="bx bx-bell me-2"></i>
                        <div class="me-auto fw-semibold">Notification</div>
                        <small>Just Now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ $message }}
                    </div>
                </div>
            @endif


            @if (session('succes_message'))
                <div class= "alert alert-succes">
                    {{ session('succes_message') }}
                </div>
            @endif
        </div>


        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product /</span> Product List</h4>
        <div class="card">
            <a class="card-header " href="{{ route('products.create') }}"><button type="button"
                    class="btn rounded-pill btn-info " style="float:right;">Create</button></a>

            <div class="table-responsive text-nowrap">

                <table class="table">
                    <caption class="ms-4">
                        List of Projects
                    </caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <th scope="row">#{{ $product->iteration }}</th>
                                <td>{{ $product->name }}</td>
                                <td>${{ $product->price }}</td>
                                <td>
                                    @foreach ($cats as $cat)
                                        {{ $cat->id == $product->category_id ? $cat->name : '' }}
                                    @endforeach
                                </td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('products.show', $product->id) }}"
                                            class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>

                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Do you want to delete this product?');"><i
                                                class="bi bi-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>No Product Found!</strong>
                                </span>
                            </td>
                        @endforelse

                    </tbody>
                </table>

                <div class="px-4">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
@stop()
