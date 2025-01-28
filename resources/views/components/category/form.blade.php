<div class="row ">
 
    <div class="col-sm-12">
        <div class="form-group position-relative mb-3">
            <label for="type" class="form-label"> Type <span class="text-danger">*</span></label>
            @php
                $type = 1; // Default to main category
                if (isset($data)) {
                    $type = $data->sub_category_id ? 3 : 
                            ($data->category_id ? 2 : 1);
                }
            @endphp
            <select id="type" name="type" class="custom-select2">
                <option @selected($type == 1)  value="1">MainCategory</option>
                <option @selected($type == 2) value="2">SubCategory</option>                
                <option @selected($type == 3)  value="3">ChildCategory</option>                
            </select>
        </div>
    </div>


    <div class="col-sm-12 mainCategory" style="{{ $type == 1 ? 'display: none;' : 'display: block;' }}">
        <div class="form-group position-relative mb-3">
            <label for="category_id" class="form-label"> Category</label>
            <select id="category_id" name="category_id" class="category_select2">
                <option value="">--Select--</option>  
                @if ($type == 2)
                    <option value="{{ $data->category_id }}" selected>{{ $data->category->name }}</option>
                @endif
                @if ($type == 3)
                    <option value="{{ $data->subCategory->category_id }}" selected >{{ $data->subCategory->category->name }}</option>
                @endif            
            </select>
        </div>
    </div>

    <div class="col-sm-12 subCategory" style="{{ $type == 1 || $type == 2 ? 'display: none;' : 'display: block;' }}">
        <div class="form-group position-relative mb-3">
            <label for="sub_category_id" class="form-label">Sub Category</label>
            <select id="sub_category_id" name="sub_category_id" class="sub_category_select2">
                <option value="">--Select--</option>   
                @if ($type == 3)
                    <option value="{{ $data->subCategory->id }}" selected >{{ $data->subCategory->name }}</option>
                @endif             
            </select>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group position-relative mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ $data->name ?? '' }}" id="name"
                placeholder="Name...">
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group position-relative mb-3">
            <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
            <input type="file"  name="image" class="form-control"  id="image">
            @if (isset($data->image))
            <img src="{{ asset($data->image) }}" alt="image" class="img-fluid mt-2" style="max-width: 100px;">
            @endif
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select id="status" name="status" class="custom-select2">
                <option @selected(isset($data) && ($data->status == '1')) value="1" >Active</option>
                <option @selected(isset($data) && ($data->status == '0')) value="0" >InActive</option>
            </select>
        </div>
    </div>


    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary btn-sm w-100 mt-3">Save</button>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#type').on('change', function() {
            var type = $(this).val();
            if (type == 2) {
                $('.mainCategory').show();
            }else if (type == 3) {
                $('.mainCategory').show();
                $('.subCategory').show();
            }else{
                $('.mainCategory').hide();
                $('.subCategory').hide();
            }
        });

        $('.category_select2').select2({
            placeholder: "Select category...",
            theme: "bootstrap-5",
            ajax: {
                url: "{{ Request::url() }}",
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(res) {
                    let data = res.data.data || [];
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                            };
                        })
                    };
                }
            },
        });
        $('.sub_category_select2').select2({
            placeholder: "Select subcategory...",
            theme: "bootstrap-5",
            ajax: {
                url: "{{ Request::url() }}",
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        category_id: $('#category_id').val(),
                    };
                },
                processResults: function(res) {
                    let data = res.data.data || [];
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                            };
                        })
                    };
                }
            },
        });
    });
</script>
@endpush