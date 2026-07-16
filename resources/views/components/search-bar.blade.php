@props(['placeholder' => 'Cari...', 'value' => null])

<div class="input-group">
    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
    <input type="text" name="search" class="form-control border-start-0"
           placeholder="{{ $placeholder }}"
           value="{{ $value ?? request('search') }}">
</div>