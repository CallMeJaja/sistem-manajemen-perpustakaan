@props(['type' => 'success', 'session' => null, 'dismissible' => false])

@if($session && session($session))
    <div class="alert alert-{{ $type }} {{ $dismissible ? 'alert-dismissible' : '' }} fade show d-flex align-items-start gap-2 mb-3" role="alert">
        @if($type === 'success')
            <i class="bi bi-check-circle mt-1"></i>
        @elseif($type === 'danger' || $type === 'error')
            <i class="bi bi-exclamation-triangle mt-1"></i>
        @elseif($type === 'warning')
            <i class="bi bi-exclamation-triangle mt-1"></i>
        @elseif($type === 'info')
            <i class="bi bi-info-circle mt-1"></i>
        @endif
        <div>{{ session($session) }}</div>
        @if($dismissible)
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        @endif
    </div>
@endif