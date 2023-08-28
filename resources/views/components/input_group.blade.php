<?php
    $id = $id ?? $name;
    $errorName = $errorName ?? $name;
    $required = isset($required) ? $required : false;
    $type = $type ?? 'text';
    $disabled = $disabled ?? false;
    $data = $data ?? [];
    $addonLeft = $addonLeft ?? null;
?>
@if ($label !== false)
    <div class="form-group  {{ $errors->has($errorName) ? 'has-error' : '' }}">

        <label for="{{ $id }}">
            {{ $label }}
            @if ($required)
                <code>*</code>
            @endif
        </label>
    @endif

    <?php
    $defaultValue = old($name) ?? $defaultValue ?? null;
    $type = $type ?? 'text';
    $view = 'admin::components.types.' . $type;
    ?>
    @if (view()->exists($view))
        @if ($addonLeft !== null)
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">{{ $addonLeft }}</span>
                </div>
                @include('admin::components.types.' . $type)
            </div>
        @else
            @include('admin::components.types.' . $type)
        @endif

    @else
        <input type="{{ $type }}"
               class=" @error($errorName) is-invalid @enderror"
               id="{{ $id }}"
               name="{{ $name }}"
               value="{{ $defaultValue }}"
               @foreach($data as $key => $value)
                   data-{{ $key }}="{{ $value }}"
               @endforeach
        >
    @endif

    @if ($errors->has($errorName))
        <span class="help-block error invalid-feedback">
            <strong>{{ $errors->first($errorName) }}</strong>
        </span>
    @endif
@if ($label !== false)
    </div>
@endif
