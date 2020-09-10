<form action="/mypage" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>目標:</label>
                <input type="text" name="targetTitle" class="form-control" placeholder="小さな目標" value="{{ $newTarget->title }}">
            </div>

            <div class="form-group">
                <label>小目標:</label>
                <input type="text" name="goalTitle" class="form-control" placeholder="説明" value="{{ $newGoal->title }}">
            </div>

            <div class="form-group">
                <label>備考:</label>
                <input type="text" name="targetDetail" class="form-control" placeholder="説明" value="{{ $newTarget->detail }}">
            </div>

            <div class="modal-footer form-group">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             <button type="button" class="btn btn-primary btn-submit">Save changes</button>
            </div>
        </form>