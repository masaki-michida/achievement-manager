<div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      <div class="modal-body">
        @include('mypage/form')
      </div>
      <div class="modal-footer form-group">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             <button type="button" class="btn btn-primary btn-submit btn-submit-new-post" data-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>