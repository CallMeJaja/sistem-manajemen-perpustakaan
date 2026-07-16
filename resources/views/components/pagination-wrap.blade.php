@props(['paginator'])

@if($paginator->hasPages())
    <div class="mt-3">
        {{ $paginator->links('pagination.custom') }}
    </div>
@endif