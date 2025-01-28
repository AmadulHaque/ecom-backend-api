@foreach ($settings as $setting)
<div class="mb-3">
    <label for="{{ $setting->key }}" class="form-label">{{ $setting->label }}</label>
    @if ($setting->type === 'text' or $setting->type === 'number')
    <input type="{{ $setting->type }}" name="{{ $setting->key }}" id="{{ $setting->key }}" class="form-control"
        placeholder="{{ $setting->placeholder }}" value="{{ $setting->value }}">
    @elseif ($setting->type === 'file')
    <input type="file" name="{{ $setting->key }}" id="{{ $setting->key }}" class="form-control">
    <img src="{{ asset('storage/'.$setting->value) }}" alt="" class="siteLogo">
    @elseif ($setting->type === 'textarea')
    <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" class="form-control"
        placeholder="{{ $setting->placeholder }}">{{ $setting->value }}</textarea>
    @elseif ($setting->type === 'boolean')
    <select name="{{ $setting->key }}" id="{{ $setting->key }}" class="form-control">
        <option value="1" {{ $setting->value == 1 ? 'selected' : '' }}>Yes</option>
        <option value="0" {{ $setting->value == 0 ? 'selected' : '' }}>No</option>
    </select>
    @elseif ($setting->type === 'select' && $setting->options === 'custom_location' )
    @php
    $divisions = App\Models\Location::whereNull('parent_id')->with('children.children')->get();
    $values = explode(',', $setting->value);
    @endphp

    <select name="{{ $setting->key }}[]" id="{{ $setting->key }}" class="form-control manyselect2" multiple="multiple">
        @foreach ($divisions as $division)
        <optgroup label="{{ $division->name }}">
            @foreach ($division->children as $district)
        <optgroup label="-- {{ $district->name }}">
            @foreach ($district->children as $city)
            <option value="{{ $city->id }}" {{ is_array($values) && in_array($city->id, $values) ? 'selected' : '' }}>
                {{ $city->name }}
            </option>
            @endforeach
        </optgroup>
        @endforeach
        </optgroup>
        @endforeach
    </select>
    <script>
    $(document).ready(function() {
        $(".manyselect2").select2({
            theme: "bootstrap-5",
            placeholder: "Select locations"
        });
    });
    </script>
    @elseif ($setting->type === 'select')
    <select name="{{ $setting->key }}" id="{{ $setting->key }}" class="form-control">
        @foreach (explode(',', $setting->options) as $option)
        <option value="{{ $option }}" {{ $setting->value === $option ? 'selected' : '' }}>{{ ucfirst($option) }}
        </option>
        @endforeach
    </select>
    @endif
</div>
@endforeach

<button type="submit" class="btn btn-sm btn-primary">Save</button>