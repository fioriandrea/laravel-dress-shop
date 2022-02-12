<div class="d-flex w-auto align-items-center">
    <label for="pagination-select" class="me-2">@lang('labels.Pagination')</label>
    <select id="pagination-select" class="form-select form-select-sm w-auto">
        @foreach([4, 6, 10] as $num)
        <option {{ $loop->first ? 'selected' : '' }} value="{{ $num }}">{{ $num }}</option>
        @endforeach
    </select>
</div>