<div class="row ">
    <div class="col-sm-12">
        <div class="form-group position-relative mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $data->title ?? '' }}" id="title"
                placeholder="Title...">
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group position-relative mb-3">
            @php $sliderType = $data->slider_type->value ?? null; @endphp          
            <label for="slider_type" class="form-label">Slider Type</label>
            <select id="slider_type" name="slider_type" class="custom-select2">
                <option @selected($sliderType == 1) value="1">Root Slider</option>
                <option @selected($sliderType == 2) value="2">Shop Slider</option>                
            </select>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group position-relative mb-3">
            <label for="sub_title" class="form-label">Sub Title</label>
            <input type="text" name="sub_title" class="form-control" value="{{ $data->sub_title ?? '' }}" id="sub_title"
                placeholder="Sub title...">
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group position-relative mb-3">
            <label for="link" class="form-label">Link</label>
            <input type="url" name="link" class="form-control" value="{{ $data->link ?? '' }}" id="link"
                placeholder="Http://...">
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group position-relative mb-3">
            <label for="link" class="form-label">Web Image (size: 350 X 350) </label>
            <input type="file" name="full_image" class="form-control" value="" id="full_image">
        </div>
        @if (isset($data->full_image))
        <div class="uplodedImage mb-3">
            <img src="{{ $data->full_image }}" alt="" class="image">
        </div>
        @endif

    </div>
    <div class="col-sm-12">
        <div class="form-group position-relative mb-3">
            <label for="link" class="form-label">Mobile Image (size: 350 X 350)</label>
            <input type="file" name="small_image" class="form-control" value="" id="small_image">
        </div>
        @if (isset($data->small_image))
        <div class="uplodedImage mb-3">
            <img src="{{ $data->small_image }}" alt="" class="image">
        </div>
        @endif
    </div>

    <div class="col-sm-12 mt-3">
        <label for="">Status</label>
        <select id="status" name="status" class="custom-select2">
            <option @selected(isset($data) && ($data->status == 'active')) value="active">Active</option>
            <option @selected(isset($data) && ($data->status == 'inactive')) value="inactive">InActive</option>
        </select>
    </div>
    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary btn-sm w-100 mt-3">Save</button>
    </div>
</div>