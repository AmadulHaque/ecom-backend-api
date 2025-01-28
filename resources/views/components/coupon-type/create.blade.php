<div class="modal" id="createModal">
    <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header">
             <h6 class="font-18 mt-2">Add Coupon Type</h6>
             <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="saveButton" action="{{ route('admin.coupon-types.store') }}" method="POST" class="needs-validation add-supplier-form" novalidate="">
                   @csrf
                   <div class="row">
                     <div class="col-sm-12">
                         <div class="form-group position-relative mb-3">
                             <label for="name" class="form-label">Name*</label>
                             <input type="text" name="name" class="form-control"  id="name" placeholder="Name..." required="">
                          </div>
                     </div>
                    <div class="col-sm-12">
                       <button type="submit" class="btn btn-primary btn-sm w-100 mt-3">Save</button>
                    </div>
                 </div>
               </form>
          </div>
       </div>
    </div>
</div>