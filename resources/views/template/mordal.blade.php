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
             <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal">閉じる</button>
             <button type="button" class="btn btn-primary btn-submit btn-submit-new-post">送信</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('.modal-close').on('click',(e)=>{
    while(addInputCounter>0){
      $(`.addedGoal${addInputCounter}`).remove();
      addInputCounter -= 1;
    }
    addInputCounter = 1;
      $('.form-control').val('');
      $('.error-title').text('');
      $('.error-goal').text('');
  })
</script>