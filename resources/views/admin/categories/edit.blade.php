@extends('layouts.sneat_master')

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Edit Category
                    </div>
                    <div class="float-end">
                        <a href="{{ route('categories.index', $cate->id) }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $cate->id) }}" method="post">
                        @csrf @method('PUT')
                        <input type="hidden" name="id" value="{{ $cate->id }}">

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                            <div class="col-md-6">
                                <input type="text" step="0.01"
                                    class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                    value="{{ $cate->name }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="status" class="col-md-4 col-form-label text-md-end text-start">Status</label>
                            <div class="col-md-6">
                                <div class="form-check mt-3 d-flex">
                                    <label class="form-check-label" style="margin-right:50px"> Publish
                                        <input name="status" class="form-check-input  @error('name') is-invalid @enderror"
                                            type="radio" name="status" value="1"
                                            {{ $cate->status == 1 ? 'checked' : '' }}>
                                    </label>

                                    <label class="form-check-label"> Private
                                        <input name="status" class="form-check-input  @error('name') is-invalid @enderror"
                                            type="radio" name="status" value="0"
                                            {{ $cate->status == 0 ? 'checked' : '' }}>
                                    </label>
                                </div>
                                @if ($errors->has('status'))
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Save Change">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
