@extends('mypage/layout')
@section('content')
<!DOCTYPE html>
<html>
<body>

    <div class="container">
        <h1>Your Page</h1>
        {{ $users }}
        {{ $targets }}
        <form action="/mypage" method="post">

            <div class="form-group">
                <label>目標:</label>
                <input type="text" name="title" class="form-control" placeholder="小さな目標" value="{{ $target->title }}">
            </div>
  
            <div class="form-group">
                <label>詳細:</label>
                <input type="text" name="detail" class="form-control" placeholder="説明" value="{{ $target->detail }}">
            </div>
   
            <div class="form-group">
                <strong>達成度:</strong>
                <input type="integer" name="archievement" class="form-control" placeholder="数字を入れてね" value="{{ $target->archievement }}">
            </div>

            <div class="form-group">
                <button class="btn btn-success btn-submit">送信</button>
            </div>
  
        </form>
    </div>
    <div class="row">
  <div class="col-md-11 col-md-offset-1">
    <table class="table text-center">
      <tr>
        <th class="text-center">タイトル</th>
        <th class="text-center">詳細</th>
        <th class="text-center">達成度</th>
      </tr>
      @foreach($targets as $tar)
      <tr>
        <td>{{ $tar->title }}</td>
        <td>{{ $tar->detail  }}</td>
        <td>{{ $tar->archievement }}</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
</body>
<script type="text/javascript">
   
   var clearForm = ()=>{

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
          $(".form-control").val('');
          
          alert('成功だ');
        }).fail(()=>{
          alert('fail');
        })
  
	});
</script>
   
</html>
@endsection