@extends('mypage/layout')
@section('content')
<!DOCTYPE html>
<html>
<body>
    <div class="container">
        <h1>Your Page</h1>

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

            <div class="form-group">
                <button class="btn btn-success btn-submit">送信</button>
            </div>
        </form>
        <div class="row">
          <div class="col-md-9 col-md-offset-1">
            <table class="table text-center" >
            <tr class="add-data">
            <th class="text-center">タイトル</th>
            <th class="text-center">詳細</th>
            <th class="text-center">達成度</th>
            <th class="text-center">経過時間</th>
            </tr>
            </tr>
            @foreach($targets as $target)
            <tr>
            <td>{{ $target->title }}</td>
            <td>{{ $target->detail }}</td>
            <td>{{ $target->archievement }}%</td>
            <td class="passedTime{{ $targetsCount-($loop->iteration) }}"></td>
            <td>{{ $targetsCount-($loop->iteration) }}</td>
            </tr>
            @endforeach
            </table>
          </div>
        </div>
    </div>
</body>
<script>
var created_at = @json($created_at);
var passedTimeDom = @json($targetsCount)-1;

setInterval(()=>{
  created_at.forEach((val,passedTimeDom)=>{
  var create_time = new Date(val).getTime();
  var nowTime = new Date().getTime();
  var passedTime2 = nowTime-create_time;
  var passedDay = Math.floor(passedTime2/(1000 * 60 * 60 * 24));
  var passedHour = Math.floor(passedTime2/(1000 * 60 * 60));
  var passedMinutes = Math.floor(passedTime2/(1000 * 60));
  var passedSeconds = Math.floor(passedTime2/1000);
  var timeTemplate = `${passedDay}日:${passedHour-(passedDay*24)}時間:${passedMinutes-(passedHour*60)}分:${passedSeconds-(passedMinutes*60)}秒`;
  $(`.passedTime${passedTimeDom}`).html(timeTemplate);
  passedTimeDom-=1;
  }
)},1000)

function htmlBuilder(localVar,counter){

  var html = 
      `<tr>
        <td>${localVar[0]['title']}</td>
        <td>${localVar[0]['detail']}</td>
        <td>${localVar[0]['archievement']}%</td>
        <td class="passedTime${counter}"></td>
       </tr>
       `
      return html
}

  function passedTime(postedTime,counter) {
    var nowTime = new Date().getTime();
    var passedTime = nowTime - postedTime
    $(`.passedTime${counter}`).html(passedTime);
  }

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $(".btn-submit").click(function(e){

      e.preventDefault();
 
      var title = $("input[name=title]").val();
      var detail = $("input[name=detail]").val();
      var archievement = $("input[name=archievement]").val();

      $.ajax({
         type:'POST',
         url:"{{ route('mypage.ajaxPost') }}",
         dataType:'json',
         data:{title,detail,archievement}
      }).done((data)=>{
        passedTimeDom+=1;
        $(".form-control").val('');
        $('.add-data').after(htmlBuilder(data,passedTimeDom));
        created_at.push(new Date());
      }).fail(()=>{
        alert('入力に不備があります');
      })
});
</script>
</html>
@endsection