@props([ 'labels', 'fullwidth', 'field_name', 'class', 'dark', 'select2', 'countries', 'selectedCountry', 'selectedState', 'selectedCity'])

<div class="{{ $class }}">
    @if($labels)
    <label for="{{$field_name}}-country">{{ __('Country') }}</label>
    @endif
    <select @if($fullwidth) style="width: 100% !important;" @endif class="form-control @if($select2) select2-show-search @endif " id="{{$field_name}}-country" name="{{$field_name}}[country_id]" wire:model="countryId">
        <option value="">{{ __('Select Country') }}</option>
        @foreach($countries as $id => $name)
            <option value="{{ $id }}"{{ $selectedCountry == $id ? ' selected' : '' }}>{{ $name }}</option>
        @endforeach
    </select>
</div>

<div class="{{ $class }}">
    @if($labels)
    <label for="{{$field_name}}-state">{{ __('State') }}</label>
    @endif
    <select @if($fullwidth) style="width: 100% !important;" @endif  class="form-control @if($select2) select2-show-search @endif" id="{{$field_name}}-state" name="{{$field_name}}[state_id]" wire:model="stateId">
        <option value="">{{ __('Select State') }}</option>
        @foreach($states as $row)
            <option value="{{ $row['id'] }}"{{ $selectedState == $row['id'] ? ' selected' : '' }}>{{ $row['name'] }}</option>
        @endforeach
    </select>
</div>

<div class="{{ $class }}">
    @if($labels)
    <label for="{{$field_name}}-city">{{ __('City') }}</label>
    @endif
    <select @if($fullwidth) style="width: 100% !important;" @endif  class="form-control @if($select2) select2-show-search @endif" id="{{$field_name}}-city" name="{{$field_name}}[city_id]" wire:model="cityId">
        <option value="">{{ __('Select City') }}</option>
        @foreach($cities as $row)
            <option value="{{ $row['id'] }}"{{ $selectedCity == $row['id']  ? ' selected' : '' }}>{{ $row['name'] }}</option>
        @endforeach
    </select>
</div>

@push( config('laravel-countries.script_stack') )
    @if($select2)
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countrySelect = document.querySelector('#{{$field_name}}-country');
        const stateSelect = document.querySelector('#{{$field_name}}-state');
        const citySelect = document.querySelector('#{{$field_name}}-city');

        countrySelect.addEventListener('change', function () {
            let url = "{{ route('laravel-countries.states.index', ':id') }}"
            url = url.replace(':id', this.value)
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    stateSelect.innerHTML = '';
                    citySelect.innerHTML = '';
                    stateSelect.insertAdjacentHTML('beforeend', '<option value="">{{ __("Select State") }}</option>');

                    data.forEach(state => {
                        stateSelect.insertAdjacentHTML('beforeend', `<option value="${state.id}">${state.name}</option>`);
                    });
                });
        });
        stateSelect.addEventListener('change', function () {
            let url = "{{ route('laravel-countries.cities.index', ':id') }}"
            url = url.replace(':id', this.value)
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    citySelect.innerHTML = '';
                    citySelect.insertAdjacentHTML('beforeend', '<option value="">{{ __("Select City") }}</option>');

                    data.forEach(city => {
                        citySelect.insertAdjacentHTML('beforeend', `<option value="${city.id}">${city.name}</option>`);
                    });
                });
        });

    @if($select2)


        $('.select2-show-search').select2({
            @if($dark)
            containerCssClass: 'select2-dark',
            dropdownCssClass: 'select2-dark',
            @endif
            minimumResultsForSearch: ''
        });

        $('#{{$field_name}}-country').on('select2:select', function (e) {
            // console.log(e.params.data)
            let url = "{{ route('laravel-countries.states.index', ':id') }}"
            url = url.replace(':id', e.params.data.id)
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    stateSelect.innerHTML = '';
                    citySelect.innerHTML = '';
                    stateSelect.insertAdjacentHTML('beforeend', '<option value="">{{ __("Select State") }}</option>');

                    data.forEach(state => {
                        stateSelect.insertAdjacentHTML('beforeend', `<option value="${state.id}">${state.name}</option>`);
                    });
                });
        });

        $('#{{$field_name}}-state').on('select2:select', function (e) {
            // console.log(e.params.data)
            let url = "{{ route('laravel-countries.cities.index', ':id') }}"
            url = url.replace(':id', e.params.data.id)
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    citySelect.innerHTML = '';
                    citySelect.insertAdjacentHTML('beforeend', '<option value="">{{ __("Select City") }}</option>');

                    data.forEach(city => {
                        citySelect.insertAdjacentHTML('beforeend', `<option value="${city.id}">${city.name}</option>`);
                    });
                });
        });


    @endif

    });


</script>
@endpush
@push('head-css')
    @if($select2)
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endif
@endpush