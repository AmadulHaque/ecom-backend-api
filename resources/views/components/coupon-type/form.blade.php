<form id="saveButton" action="{{ route('admin.coupon-types.update', $data->id) }}" method="POST" class="needs-validation add-supplier-form" novalidate="">
    @method('PUT')
    @csrf
    <div class="row">
      <div class="col-sm-12">
          <div class="form-group position-relative mb-3">
              <label for="name" class="form-label">Name*</label>
              <input type="text" name="name" class="form-control" value="{{ $data->name ?? ''}}" id="name" placeholder="Name..." required="">
           </div>
      </div>
     <div class="col-sm-12">
        <button type="submit" class="btn btn-primary btn-sm w-100 mt-3">Save</button>
     </div>
  </div>
</form>
 