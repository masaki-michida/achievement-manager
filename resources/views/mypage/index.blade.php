@extends('mypage/layout')
@section('content')
<!DOCTYPE html>
<html>
<body>
    <div class="container">
        <h1>Your Page</h1>
            <table class="data-table text-nowrap table table-hover table-bordered" >
            <thead class="text-center">
              <tr class="table-active">
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              </tr>
            </thead>
            <tbody>
            @foreach($targets as $target)
            <tr>
            <td class="text-center">{{ $targetsCount-($loop->iteration) }}</td>
            <td class="passedTime{{ $targetsCount-($loop->iteration) }} text-center"></td>
            <td class="text-center">{{ $target->title }}</td>
            @if(isset($target->goals[0]))
            <td>
              @foreach($target->goals as $goalList)
              <div class="form-check">
              @if($goalList->checked==1)
              <input class="form-check-input" checked='checked' type="checkbox" data-id="{{ $goalList->id }}" id="checkbox{{ $goalList->id }}" >
              @else
              <input class="form-check-input" type="checkbox" data-id="{{ $goalList->id }}" id="checkbox{{ $goalList->id }}" >
              @endif
              <label class="form-check-label" for="checkbox{{ $goalList->id }}">{{ $goalList->title }}</label>
              </div>
              @endforeach
            </td>
            @else
            <td>からです</td>
            @endif
            <td class="text-center">{{ $target->archievement }}%</td>
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
  destroy:true,
  language: {
         url: "https://cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Japanese.json"
       },
  "createdRow": function( row, data, dataIndex ) {
    if(dataIndex==passedTimeDom){
      $(row).find("td").eq(0).addClass('text-center');
      $(row).find("td").eq(1).addClass(`passedTime${passedTimeDom}`).addClass('text-center');
      $(row).find("td").eq(2).addClass('text-center');
      $(row).find("td").eq(4).addClass('text-center');
      
    }
  },
  columnDefs: [
        { "targets": 0, "name": "number", "title": "番号", "data": 0}, 
        { "targets": 1, "name": "passedTime", "title": "経過時間", "data": 1},  
        { "targets": 2, "name": "target", "title": "目標", "data": 2 },   
        { "targets": 3, "name": "goals", "title": "小目標", "data": 3,},   
        { "targets": 4, "name": "archievement", "title": "達成率", "data": 4}    
    ]
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
        buildedHtml = [];
        data[2].forEach((val)=>{
          var html = `<div class="form-check">
                        <input class="form-check-input" type="checkbox" data-id=${val['id']} id="checkbox${val['id']}">
                        <label class="form-check-label" for="checkbox${val['id']}">${val['title']}</label>
                      </div>
                     `
           buildedHtml.push(html);
        });
        var newRow = datatable.row.add([
            passedTimeDom,
            null,
            data[0]['title'],
            buildedHtml.join(""),
          `${data[0]['archievement']}%`
        ]).draw();
        created_at.push(new Date());
      }).fail(()=>{
        alert('入力に不備があります');
      })
  });

  $('table').on('change',".form-check-input",(e)=>{
    var changeBoxId = $(e.target).data('id');
    $.ajax({
      type:'PUT',
      url:"{{ route('mypage.ajaxCheckBox') }}",
      dataType:'json',
      data: {id: changeBoxId}
    }).done((data)=>{
      var tasseido = Math.floor(data['archievement']);
      var archievementCell = $(e.target).parent().parent().next();
      datatable.cell(archievementCell).data(tasseido+'%');
    })
  })
</script>
</html>
@endsection