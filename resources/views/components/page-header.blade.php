@props(['backTo' => null, 'title', 'subtitle' => null])

<div class="d-flex align-items-center gap-2 mb-4">
    @if($backTo)
        <a href="{{ $backTo }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
        </a>
    @endif
    <div>
        <h5 class="fw-bold mb-0">{{ $title }}</h5>
        @if($subtitle)
            <p class="text-muted small mb-0">{{ $subtitle }}</p>
        @endif
    </div>
</div>