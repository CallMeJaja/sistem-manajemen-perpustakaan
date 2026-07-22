@props([
    'name',
    'id',
    'label',
    'placeholder' => 'Ketik untuk mencari...',
    'searchUrl',
    'required' => false,
    'oldValue' => null,
    'oldLabel' => null,
])

<div class="autocomplete-wrapper position-relative"
     data-url="{{ $searchUrl }}"
     data-target="{{ $name }}">
    <label for="{{ $id }}" class="form-label fw-medium">
        {{ $label }} @if($required)<span class="text-danger">*</span>@endif
    </label>

    <div class="input-group autocomplete-input-group @if($oldLabel) d-none @endif">
        <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
        <input type="text"
               id="{{ $id }}"
               class="form-control autocomplete-input @error($name) is-invalid @enderror"
               placeholder="{{ $placeholder }}"
               autocomplete="off"
               @if($required) required @endif>
        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <input type="hidden" name="{{ $name }}" class="autocomplete-value"
           value="{{ old($name, $oldValue) }}">

    <div class="autocomplete-selected @unless($oldLabel) d-none @endunless mt-2">
        <div class="d-flex align-items-center gap-2 p-2 bg-light rounded border">
            <i class="bi bi-check-circle-fill text-success"></i>
            <span class="autocomplete-selected-text flex-grow-1 small">{{ $oldLabel }}</span>
            <button type="button" class="btn btn-sm btn-outline-danger autocomplete-clear"
                    title="Hapus pilihan">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>

    <div class="autocomplete-dropdown position-absolute w-100 bg-white border rounded-bottom shadow-sm d-none"
         style="z-index:1050; max-height:300px; overflow-y:auto;"></div>
</div>

@pushOnce('styles')
<style>
    .autocomplete-wrapper .autocomplete-dropdown .autocomplete-item {
        padding: 10px 14px;
        cursor: pointer;
        border-bottom: 1px solid #f1f3f5;
        transition: background-color 0.15s;
    }
    .autocomplete-wrapper .autocomplete-dropdown .autocomplete-item:hover,
    .autocomplete-wrapper .autocomplete-dropdown .autocomplete-item.active {
        background-color: #f8f9fa;
    }
    .autocomplete-wrapper .autocomplete-dropdown .autocomplete-item:last-child {
        border-bottom: none;
    }
    .autocomplete-wrapper .autocomplete-no-result,
    .autocomplete-wrapper .autocomplete-loading {
        padding: 12px 14px;
        text-align: center;
        color: #868e96;
        font-size: 0.875rem;
    }
</style>
@endpushOnce

@pushOnce('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.autocomplete-wrapper').forEach(function (wrapper) {
        const input = wrapper.querySelector('.autocomplete-input');
        const hidden = wrapper.querySelector('.autocomplete-value');
        const dropdown = wrapper.querySelector('.autocomplete-dropdown');
        const selected = wrapper.querySelector('.autocomplete-selected');
        const selectedText = wrapper.querySelector('.autocomplete-selected-text');
        const clearBtn = wrapper.querySelector('.autocomplete-clear');
        const inputGroup = wrapper.querySelector('.autocomplete-input-group');
        const searchUrl = wrapper.dataset.url;
        const targetField = wrapper.dataset.target;
        let debounceTimer, activeIndex = -1;

        input.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            const q = this.value.trim();
            if (q.length < 2) { hideDropdown(); return; }
            debounceTimer = setTimeout(function () { fetchResults(q); }, 300);
        });

        input.addEventListener('keydown', function (e) {
            const items = dropdown.querySelectorAll('.autocomplete-item');
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIndex = Math.min(activeIndex + 1, items.length - 1);
                updateActive(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIndex = Math.max(activeIndex - 1, -1);
                updateActive(items);
            } else if (e.key === 'Enter' && activeIndex >= 0) {
                e.preventDefault();
                items[activeIndex]?.click();
            } else if (e.key === 'Escape') {
                hideDropdown();
            }
        });

        input.addEventListener('focus', function () {
            const q = this.value.trim();
            if (q.length >= 2) fetchResults(q);
        });

        clearBtn.addEventListener('click', function () {
            input.value = '';
            hidden.value = '';
            selected.classList.add('d-none');
            inputGroup.classList.remove('d-none');
            input.focus();
        });

        document.addEventListener('click', function (e) {
            if (!wrapper.contains(e.target)) hideDropdown();
        });

        async function fetchResults(q) {
            showLoading();
            try {
                const response = await fetch(searchUrl + '?q=' + encodeURIComponent(q), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await response.json();
                renderResults(data);
            } catch (err) {
                hideDropdown();
            }
        }

        function renderResults(items) {
            dropdown.innerHTML = '';
            if (!items.length) {
                dropdown.innerHTML = '<div class="autocomplete-no-result">Tidak ditemukan</div>';
                showDropdown();
                return;
            }
            items.forEach(function (item, i) {
                const div = document.createElement('div');
                div.className = 'autocomplete-item';
                div.dataset.index = i;
                div.innerHTML = getDisplayHTML(item);
                div.addEventListener('click', function () { selectItem(item); });
                dropdown.appendChild(div);
            });
            activeIndex = -1;
            showDropdown();
        }

        function selectItem(item) {
            hidden.value = (targetField === 'borrow_number') ? item.borrow_number : item.id;
            input.value = getDisplayText(item);
            selectedText.innerHTML = getDisplayHTML(item);
            selected.classList.remove('d-none');
            inputGroup.classList.add('d-none');
            hideDropdown();
            hidden.dispatchEvent(new CustomEvent('autocomplete:select', { detail: item }));
        }

        function getDisplayHTML(item) {
            if (targetField === 'member_id') {
                return '<div class="fw-semibold">' + esc(item.member_number) + ' &mdash; ' + esc(item.name) + '</div>' +
                    '<div class="small text-muted">' + esc(item.email) + ' &middot; ' + esc(item.phone || '-') + '</div>';
            }
            if (targetField === 'book_id') {
                return '<div class="fw-semibold">' + esc(item.title) + '</div>' +
                    '<div class="small text-muted">' + esc(item.author) + ' &middot; ' + esc(item.isbn || '-') + ' &middot; Stok: ' + item.available_stock + '</div>';
            }
            if (targetField === 'borrow_number') {
                var text = '<div class="fw-semibold">' + esc(item.borrow_number) + '</div>';
                var sub = [];
                if (item.member) sub.push(esc(item.member.name));
                if (item.book) sub.push(esc(item.book.title));
                if (sub.length) text += '<div class="small text-muted">' + sub.join(' &middot; ') + '</div>';
                return text;
            }
            return '<div class="fw-semibold">' + esc(item.name || item.title || '') + '</div>';
        }

        function getDisplayText(item) {
            if (targetField === 'member_id') return item.member_number + ' — ' + item.name;
            if (targetField === 'book_id') return item.title + ' — ' + item.author;
            if (targetField === 'borrow_number') return item.borrow_number;
            return item.name || item.title || '';
        }

        function esc(str) {
            if (!str) return '';
            var d = document.createElement('div');
            d.appendChild(document.createTextNode(str));
            return d.innerHTML;
        }

        function updateActive(items) {
            items.forEach(function (el, i) { el.classList.toggle('active', i === activeIndex); });
            items[activeIndex]?.scrollIntoView({ block: 'nearest' });
        }

        function showLoading() {
            dropdown.innerHTML = '<div class="autocomplete-loading"><i class="bi bi-arrow-repeat me-1"></i>Mencari...</div>';
            showDropdown();
        }

        function showDropdown() { dropdown.classList.remove('d-none'); }
        function hideDropdown() { dropdown.classList.add('d-none'); activeIndex = -1; }
    });
});
</script>
@endpushOnce
