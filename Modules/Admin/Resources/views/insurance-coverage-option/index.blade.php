@extends('admin::layouts.master')

@section('title')
    Insurance Coverage Options
    <a class="btn btn-primary" href="{{route('admin.insurance-coverage-option.create')}}">Create</a>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Insurance Coverage Options</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Coverage</th>
                                <th>Price Percentage</th>
                                <th style="width: 100px">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($coverageOptions as $coverageOption)
                                <tr>
                                    <td>{{$coverageOption->coverage}}$</td>
                                    <td>{{$coverageOption->price_percentage}}%</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{route('admin.insurance-coverage-option.edit', $coverageOption->id)}}">
                                            <i class="fas fa-pen"></i>
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $coverageOptions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
