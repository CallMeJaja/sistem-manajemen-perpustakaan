@props(['placeholder' => 'Cari...', 'value' => null, 'label' => null, 'id' => 'search'])

@if($label)
<label for="{{ $id }}" class="form-label fw-medium mb-0">{{ $label }}</label>
@endif
<div class="input-group">
    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
    <input type="text" name="search" id="{{ $id }}" class="form-control border-start-0"
           placeholder="{{ $placeholder }}"
           value="{{ $value ?? request('search') }}">
</div>
