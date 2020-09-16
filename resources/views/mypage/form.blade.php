<form action="/mypage" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>目標:</label>
                <input type="text" name="targetTitle" class="form-control" placeholder="小さな目標" value="{{ $newTarget->title }}">
            </div>

            <div class="form-group new-goal">
                <label>小目標:</label>
                <input type="text" name="goalTitle[0]" class="form-control" placeholder="説明" value="{{ $newGoal->title }}">
            </div>

            <button type="button" class="btn btn-link btn-lg active add-new-goal" data_but="btn-xs"> 
            <i class='fa fa-plus-circle'></i>
            </button>

            <button type="button" class="btn btn-link btn-lg active delete-goal" data_but="btn-xs"> 
            <i class='fa fa-minus-circle'></i>
            </button>

            <div class="form-group">
                <label>備考:</label>
                <input type="text" name="targetDetail" class="form-control" placeholder="説明" value="{{ $newTarget->detail }}">
            </div>
        </form>
<script>

var addInputCounter = 1;

$('.add-new-goal').on('click',(e)=>{
    e.preventDefault();
    var htmlGoal = `

        <input type="text" name="goalTitle[${addInputCounter}]" class="form-control mt-3 addedGoal${addInputCounter}" placeholder="説明" value="{{ $newGoal->title }}">
    `
    $(`.new-goal`).append(htmlGoal);

    addInputCounter += 1;
})


$('.delete-goal').on('click',(e)=>{
    e.preventDefault();
    if(addInputCounter != 1){
    addInputCounter -= 1;
    $(`.addedGoal${addInputCounter}`).remove();
    }
});

</script>