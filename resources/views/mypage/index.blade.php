@extends('mypage/layout')
@section('content')
<!DOCTYPE html>
<html>
<body>
    <div class="container">
        <h1>Your Page</h1>
            <table class="data-table text-nowrap table text-center table-hover table-bordered" >
            <thead>
              <tr class="table-active">
              <th class="text-center" >番号</th>
              <th class="text-center" >経過時間</th>
              <th class="text-center" >目標</th>
              <th class="text-center" >小目標</th>
              <th class="text-center" >達成度</th>
              </tr>
            </thead>
            <tbody class="add-data">
            @foreach($targets as $target)
            <tr data-toggle="modal" data-target="#form-modal">
            <td>{{ $targetsCount-($loop->iteration) }}</td>
            <td class="passedTime{{ $targetsCount-($loop->iteration) }}"></td>
            <td>{{ $target->title }}</td>
            @if(isset($target->goals[0]))
            <td>{{ $target->goals[0]->title }}</td>
            @else
            <td>からです</td>
            @endif
            <td>{{ $target->archievement }}%</td>
            </tr>
            @endforeach
            </tbody>
            </table>
    </div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form-modal">
          目標を立てる
    </button>
    @include('template/mordal')
</body>
<script>

var datatable = $(".data-table").DataTable({
  "order": [[0,'desc']],
  "createdRow": function( row, data, dataIndex ) {
    if(dataIndex==passedTimeDom){
    $(row).attr("data-toggle","modal").attr("data-target","#form-modal");
    $(row).find("td").eq(1).addClass(`passedTime${passedTimeDom}`);
    }
  }
});

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

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $(".btn-submit").click(function(e){

      e.preventDefault();
 
      var title = $("input[name=targetTitle]").val();
      var detail = $("input[name=targetDetail]").val();
      var goal = [];
      for(var i=0; i<=addInputCounter; i++){
      goal.push($(`input[name="goalTitle[${i}]"]`).val());
      }
      $.ajax({
         type:'POST',
         url:"{{ route('mypage.ajaxPost') }}",
         dataType:'json',
         data: {
           title:title,
           detail:detail,
           goal:goal
         }
      }).done((data)=>{
        passedTimeDom+=1;
        $(".form-control").val('');
        var newRow = $('.data-table').DataTable().row.add([
          passedTimeDom,
          null,
          data[0]['title'],
          data[2],
          `${data[0]['archievement']}%`
        ]).draw();
        created_at.push(new Date());
      }).fail(()=>{
        alert('入力に不備があります');
      })
});
</script>
</html>
@endsection