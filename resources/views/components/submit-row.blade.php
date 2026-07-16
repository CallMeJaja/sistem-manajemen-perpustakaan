@props(['backTo', 'label' => 'Simpan', 'icon' => 'bi-floppy'])

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="{{ $icon }} me-1"></i>{{ $label }}
    </button>
    @if($backTo)
        <a href="{{ $backTo }}" class="btn btn-outline-secondary">Batal</a>
    @endif
</div>