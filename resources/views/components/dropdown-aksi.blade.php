@props(['align' => 'end'])

<div class="dropdown">
    <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
            data-bs-toggle="dropdown" aria-expanded="false">
        Aksi
    </button>
    <ul class="dropdown-menu dropdown-menu-{{ $align }} shadow-sm text-sm">
        {{ $slot }}
    </ul>
</div>