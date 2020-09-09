<form action="/mypage" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>目標:</label>
                <input type="text" name="title" class="form-control" placeholder="小さな目標" value="{{ $newTarget->title }}">
            </div>
  
            <div class="form-group">
                <label>詳細:</label>
                <input type="text" name="detail" class="form-control" placeholder="説明" value="{{ $newTarget->detail }}">
            </div>
   
            <div class="form-group">
                <strong>達成度:</strong>
                <input type="number" min="0" max="100" name="archievement" class="form-control" placeholder="0~100で入力してください" value="{{ $newTarget->archievement }}">
            </div>

            <div class="modal-footer form-group">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             <button type="button" class="btn btn-primary btn-submit">Save changes</button>
            </div>
        </form>