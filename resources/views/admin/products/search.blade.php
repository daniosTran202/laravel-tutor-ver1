@extends('layouts.sneat_master')

@section('content')
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <h3 class="text-center text-danger">Autocomplete Search Box!</h3>
                <hr>
                <div class="form-group">
                    <h4>Type by id, title and description!</h4>
                    <input type="text" name="search" id="search" placeholder="Enter search name" class="form-control"
                        onfocus="this.value=''">
                </div>
                <div id="search_list"></div>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>
@endsection
