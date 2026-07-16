@props(['icon' => 'bi-inbox', 'message' => 'Belum ada data.'])

<div class="text-center py-5 text-muted">
    <i class="bi {{ $icon }} fs-1 d-block mb-2"></i>
    {{ $message }}
</div>