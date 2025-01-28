<div class="row ">


    <div class="col-sm-12">
        <div class="form-group position-relative mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ $data->category_name ?? '' }}"
                placeholder="Name..." readonly>
        </div>
        <div class="form-group position-relative mb-3">
            <label for="name" class="form-label">Sub Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ $data->sub_category_name ?? '' }}"
                placeholder="Name..." readonly>
        </div>
        <div class="form-group position-relative mb-3">
            <label for="name" class="form-label">Sub Sub Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ $data->sub_sub_category_name ?? '' }}"
                placeholder="Name..." readonly>
        </div>
    </div>
    <div class="col-sm-12 mt-3">
        <label for="type">Status</label>
        <select id="type" name="type" class="custom-select2">
            <option @selected(isset($data) && $data->status == '1') value="1">Pending</option>
            <option @selected(isset($data) && $data->status == '2') value="2">Approved</option>
            <option @selected(isset($data) && $data->status == '3') value="3">Rejected</option>
        </select>
    </div>


    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary btn-sm w-100 mt-3">Save</button>
    </div>
</div>
