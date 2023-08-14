@extends('admin::layouts.master')

@section('title')
    @if($insurancePack->exists)
        {{$insurancePack['name_en']}}
        <button
            class="btn btn-danger ml-1"
            type="button"
            data-form-id="delete-insurance-pack"
            data-ask="1"
            data-title="Delete"
            data-confirm-button-color="danger"
            data-message="Delete '{{$insurancePack['name_en']}}' insurance option ?"
            data-type="warning"
        >Delete
        </button>
    @else
        Insurance Option
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('admin.insurance-pack.index')}}">Insurance Packs</a></li>
    @if($insurancePack->exists)
        <li class="breadcrumb-item active">{{$insurancePack['slug']}}</li>
    @else
        <li class="breadcrumb-item active">Create</li>
    @endif
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if($insurancePack->exists)
                            <h3 class="card-title">Edit</h3>
                        @else
                            <h3 class="card-title">Create</h3>
                        @endif
                    </div>
                    <form
                        action="{{
                                $insurancePack->exists
                                ? route('admin.insurance-pack.update', $insurancePack->id)
                                : route('admin.insurance-pack.store')
                                }}" method="post">

                        <div class="card-body">
                            @csrf
                            @if($insurancePack->exists)
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="Name EN">Name EN</label>
                                <input type="text" class="form-control" name="name_en" placeholder="Name EN"
                                       value="{{$insurancePack['name_en']}}">
                            </div>
                            <div class="form-group">
                                <label for="Description EN">Description EN</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="description_en"
                                    placeholder="Description EN"
                                    maxlength="240"
                                >{{$insurancePack['description_en']}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="Name RU">Name RU</label>
                                <input type="text" class="form-control" name="name_ru" placeholder="Name RU"
                                       value="{{$insurancePack['name_ru']}}">
                            </div>
                            <div class="form-group">
                                <label for="Description RU">Description RU</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="description_ru"
                                    placeholder="Description RU"
                                    maxlength="240"
                                >{{$insurancePack['description_ru']}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="Price">Price</label>
                                <input type="number" step=".01" class="form-control" name="price" placeholder="Price"
                                       value="{{$insurancePack->price}}">
                            </div>
                            <div class="form-group">
                                <label for="Price">Options</label>
                                <select id="options" name="insurance_options[]" class="w-100"
                                        multiple="multiple">
                                    @foreach($insurancePack->insuranceOptions as $option)
                                        <option value="{{$option->id}}" selected>
                                            {{$option->name_en}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                @if($insurancePack->exists)
                                    Update
                                @else
                                    Create
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($insurancePack->exists)
        <form
            action="{{route('admin.insurance-pack.destroy', $insurancePack->id)}}"
            method="post"
            id="delete-insurance-pack"
        >
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#options').select2({
                placeholder: 'Select Insurance Options',
                ajax: {
                    url: '{{route('admin.insurance-option.search')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            name: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        })
    </script>
@endpush
