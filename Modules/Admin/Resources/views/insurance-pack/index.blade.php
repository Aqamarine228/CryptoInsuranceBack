@extends('admin::layouts.master')

@section('title')
    Insurance Packs
    <a class="btn btn-primary" href="{{route('admin.insurance-pack.create')}}">Create</a>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Insurance Packs</li>
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
                                <th>Name EN</th>
                                <th>Name RU</th>
                                <th style="width: 100px">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($insurancePacks as $insurancePack)
                                <tr>
                                    <td>{{$insurancePack['name_en']}}</td>
                                    <td>{{$insurancePack['name_ru']}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{route('admin.insurance-pack.edit', $insurancePack->id)}}">
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
                        {{ $insurancePacks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
