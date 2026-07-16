@props(['name', 'label', 'type' => 'text', 'required' => false, 'placeholder' => null, 'help' => null, 'disabled' => false, 'rows' => null, 'value' => null, 'autofocus' => false])

@php
    $id = $name;
    $oldValue = old($name, $value ?? '');
@endphp

<div class="mb-3">
    @if($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    @if($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $id }}" rows="{{ $rows ?? 3 }}"
                  class="form-control @error($name) is-invalid @enderror"
                  @if($disabled) disabled @endif
                  placeholder="{{ $placeholder }}">{{ $oldValue }}</textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
               class="form-control @error($name) is-invalid @enderror"
               value="{{ $oldValue }}"
               @if($required) required @endif
               @if($disabled) disabled @endif
               @if($autofocus) autofocus @endif
               @if($placeholder) placeholder="{{ $placeholder }}" @endif>
    @endif

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if($help)
        <div class="form-text">{{ $help }}</div>
    @endif
</div>