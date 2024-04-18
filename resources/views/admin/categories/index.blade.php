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
        </div>


        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Categories /</span> List</h4>
        <div class="card">
            <a class="card-header " href="{{ route('categories.create') }}"><button type="button"
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
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cates as $cate)
                            <tr>
                                <th scope="row">#{{ $loop->iteration }}</th>
                                <td>{{ $cate->name }}</td>
                                <td>
                                    @if ($cate->status == 1)
                                        <span class="badge bg-label-primary me-1">Publish</span>
                                    @else
                                        <span class="badge bg-label-warning me-1">Private</span>
                                    @endif
                                </td>
                                <td class="d-flex">
                                    <a href="{{ route('categories.edit', $cate->id) }}" class="btn btn-success btn-sm"
                                        style="margin-right:10px; ">Edit</a>
                                    <form action="{{ route('categories.delete', $cate->id) }}" method="POST">
                                        @method('DELETE') @csrf
                                        <button class="btn  btn-danger btn-sm"
                                            onclick = "return confirm('Are you sure you want to delete this Category ?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>No cate Found!</strong>
                                </span>
                            </td>
                        @endforelse

                    </tbody>
                </table>

                {{ $cates->links() }}
            </div>
        </div>
    </div>
@stop()
