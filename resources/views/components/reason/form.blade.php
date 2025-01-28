<div class="row ">
    <div class="col-sm-12 mt-3">
        <label for="type">Reason Type</label>
        <select id="type" name="type" class="custom-select2">
            <option @selected(isset($data) && ($data->status == 'cancel')) value="cancel">Cancel</option>
            <option @selected(isset($data) && ($data->status == 'return')) value="return">Return</option>
            <option @selected(isset($data) && ($data->status == 'exchange')) value="exchange">Exchange</option>
            <option @selected(isset($data) && ($data->status == 'refund')) value="refund">Refund</option>
        </select>
    </div>

    <div class="col-sm-12">
        <div class="form-group position-relative mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $data->name ?? '' }}" id="name"
                placeholder="Name...">
        </div>
    </div>

    <div class="col-sm-12 mt-3">
        <label for="">Status</label>
        <select id="status" name="status" class="custom-select2">
            <option @selected(isset($data) && ($data->status == '1')) value="1">Active</option>
            <option @selected(isset($data) && ($data->status == '0')) value="0">InActive</option>
        </select>
    </div>
    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary btn-sm w-100 mt-3">Save</button>
    </div>
</div>