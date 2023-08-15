@extends('admin::layouts.master')

@section('title')
    @if($insuranceOption->exists)
        {{$insuranceOption['name_en']}}
        <button
            class="btn btn-danger ml-1"
            type="button"
            data-form-id="delete-insurance-option"
            data-ask="1"
            data-title="Delete"
            data-confirm-button-color="danger"
            data-message="Delete '{{$insuranceOption['name_en']}}' insurance option ?"
            data-type="warning"
        >Delete
        </button>
    @else
        Insurance Option
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('admin.insurance-option.index')}}">Insurance Options</a></li>
    @if($insuranceOption->exists)
        <li class="breadcrumb-item active">{{$insuranceOption['slug']}}</li>
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
                        @if($insuranceOption->exists)
                            <h3 class="card-title">Edit</h3>
                        @else
                            <h3 class="card-title">Create</h3>
                        @endif
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{
                                $insuranceOption->exists
                                ? route('admin.insurance-option.update', $insuranceOption->id)
                                : route('admin.insurance-option.store')
                                }}" id="update-insurance-option" method="post">


                            @csrf
                            @if($insuranceOption->exists)
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="Name EN">Name EN</label>
                                <input type="text" class="form-control" name="name_en" placeholder="Name EN"
                                       value="{{$insuranceOption['name_en']}}">
                            </div>
                            <div class="form-group">
                                <label for="Description EN">Description EN</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="description_en"
                                    placeholder="Description EN"
                                    maxlength="240"
                                >{{$insuranceOption['description_en']}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="Name RU">Name RU</label>
                                <input type="text" class="form-control" name="name_ru" placeholder="Name RU"
                                       value="{{$insuranceOption['name_ru']}}">
                            </div>
                            <div class="form-group">
                                <label for="Description RU">Description RU</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="description_ru"
                                    placeholder="Description RU"
                                    maxlength="240"
                                >{{$insuranceOption['description_ru']}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="Price">Price</label>
                                <input type="number" step=".01" class="form-control" name="price" placeholder="Price"
                                       value="{{$insuranceOption->price}}">
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button onclick="document.getElementById('update-insurance-option').submit()"
                                class="btn btn-primary">
                            @if($insuranceOption->exists)
                                Update
                            @else
                                Create
                            @endif
                        </button>
                    </div>
                </div>
                @if($insuranceOption->exists)
                    <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Update Fields</h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($insuranceOption->fields as $field)
                                <form action="{{route('admin.insurance-option.field.update', $field->id)}}"
                                      method="post"
                                      id="update-field-{{$field->id}}"
                                >
                                    @csrf
                                    @method('PUT')
                                    <label class="d-flex">
                                        <input
                                            type="text"
                                            required
                                            placeholder="Name EN"
                                            name="name_en"
                                            style="max-width: 200px"
                                            value="{{$field->name_en}}"
                                            class="form-control ml-1"
                                        >
                                        <input
                                            type="text"
                                            required
                                            placeholder="Name RU"
                                            name="name_ru"
                                            style="max-width: 200px"
                                            value="{{$field->name_ru}}"
                                            class="form-control ml-1"
                                        >
                                        <select
                                            disabled
                                            type="text"
                                            required
                                            class="ml-1 form-control"
                                            style="max-width: 200px;"
                                        >
                                            <option selected>
                                                {{Str::title($field->type->name)}}
                                            </option>
                                        </select>
                                        <button class="btn btn-primary btn-sm ml-1"
                                                type="submit">
                                            Update
                                        </button>
                                        <button
                                            class="btn btn-danger btn-sm ml-1"
                                            data-form-id="delete-insurance-option-field-{{$field->id}}"
                                            data-ask="1"
                                            data-title="Delete"
                                            data-confirm-button-color="danger"
                                            data-message="Delete '{{$insuranceOption['name_en']}}' insurance option field?"
                                            data-type="warning"
                                        >
                                            Delete
                                        </button>
                                    </label>
                                </form>
                                <form
                                    action="{{route('admin.insurance-option.field.destroy', $field->id)}}"
                                    id="delete-insurance-option-field-{{$field->id}}"
                                    method="post"
                                >
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endforeach
                        </div>
                    </div>
                    <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Add Fields</h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <button class="btn-primary btn btn-sm mb-3" id="addField">
                                <em class="fas fa-plus"></em>
                                New Field
                            </button>
                            <form action="{{route('admin.insurance-option.field.add', $insuranceOption->id)}}"
                                  id="new-fields"
                                  method="post">
                                @csrf
                            </form>
                        </div>
                        <div class="card-footer">
                            <button
                                class="btn btn-primary"
                                onclick="document.getElementById('new-fields').submit()"
                            >
                                Add Fields
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if($insuranceOption->exists)
        <form
            action="{{route('admin.insurance-option.destroy', $insuranceOption->id)}}"
            method="post"
            id="delete-insurance-option"
        >
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
    <script type="application/javascript" defer>

        document.getElementById('addField').onclick = () => {
            const container = document.getElementById('new-fields');
            const label = document.createElement('label');
            label.classList.add('d-flex');

            label.appendChild(createFieldName('en'));
            label.appendChild(createFieldName('ru'));
            label.appendChild(createTypeSelector());
            label.appendChild(createDeleteButton());

            container.appendChild(label);
        };

        function createFieldName(locale) {
            const fieldNameInput = document.createElement('input');
            fieldNameInput.type = 'text';
            fieldNameInput.required = true;
            fieldNameInput.classList.add('ml-1');
            fieldNameInput.placeholder = `Name ${locale.toUpperCase()}`;
            fieldNameInput.name = `names_${locale}[]`;
            fieldNameInput.classList.add('form-control');
            fieldNameInput.style.maxWidth = '200px';

            return fieldNameInput;

        }

        function createTypeSelector() {
            const selector = document.createElement('select');
            selector.name = 'types[]';
            selector.classList.add('form-control');
            selector.classList.add('ml-1');
            selector.style.maxWidth = '200px';

            const textOption = document.createElement('option');
            textOption.text = 'Text';
            textOption.value = '{{\App\Enums\InsuranceOptionFieldType::TEXT->value}}';

            const numberOption = document.createElement('option');
            numberOption.text = 'Number';
            numberOption.value = '{{\App\Enums\InsuranceOptionFieldType::NUMBER->value}}';

            selector.appendChild(textOption);
            selector.appendChild(numberOption);

            return selector;
        }

        function createDeleteButton() {
            const button = document.createElement('button');
            button.innerHTML = 'Remove';
            button.classList.add('btn');
            button.classList.add('btn-danger');
            button.classList.add('btn-sm');
            button.classList.add('ml-1');
            button.onclick = deleteField;

            return button;
        }

        function deleteField() {
            this.parentElement.remove();
        }
    </script>
@endpush
