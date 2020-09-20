@extends('mypage/layout')
@section('content')
<!DOCTYPE html>
<html>
<body>
    <div class="container">
            <table class="data-table text-nowrap table table-hover table-bordered" style="width:100%">
            <thead class="text-center bg-primary text-white">
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
            @if($target->complete==0)
            <tr>
            <td class="text-center">{{ $targetsCount-($loop->iteration) }}</td>
            <td class="passedTime{{ $targetsCount-($loop->iteration) }} text-center">{{ $target->created_at }}</td>
            <td class="text-center">{{ $target->title }}</td>
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
            <td class="text-center">
              @if($target->archievement==100)
                <form action="/mypage/compTarget/{{ $target->id }}" method="post">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-success btn-comp-target">
                      完了
                </button>
              </form>
              @else
                {{ $target->archievement }}%
              @endif
            </td>
            </tr>
            @endif
            @endforeach
            </tbody>
            </table>
    </div>
      <div class="text-center">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form-modal">
            目標を立てる
      </button>
      </div>
    @include('template/mordal')
</body>
<script>

const errorRedirect = (status,codes=[500,419,405])=>{
  codes.forEach((code)=>{
    if(code==status){
      alert('再ログインしてください');
      location.href = '/';
    }
  })
}

var createdRowElement = @json($targetsCount)-1;

var datatable = $(".data-table").DataTable({
  responsive: true,
  scrollX:true,
  "order":[0,"desc"],
  destroy:true,
  language: {
         url: "https://cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Japanese.json"
       },
  "createdRow": function( row, data, dataIndex ) {
    if(dataIndex==createdRowElement){
      $(row).find("td").eq(0).addClass('text-center');
      $(row).find("td").eq(1).addClass(`passedTime${dataIndex}`).addClass('text-center');
      $(row).find("td").eq(2).addClass('text-center');
      $(row).find("td").eq(4).addClass('text-center');
    }
    var create_time = new Date(data[1]).getTime();
    setInterval(() => {
      var nowTime = new Date().getTime();
      var passedTime2 = (nowTime-create_time);
      var passedDay = Math.floor(passedTime2/(1000 * 60 * 60 * 24));
      var passedHour = Math.floor(passedTime2/(1000 * 60 * 60));
      var passedMinutes = Math.floor(passedTime2/(1000 * 60));
      var passedSeconds = Math.floor(passedTime2/1000);
      var timeTemplate = `${passedDay}日:${passedHour-(passedDay*24)}時間:
                          ${passedMinutes-(passedHour*60)}分:
                          ${passedSeconds-(passedMinutes*60)}秒`;
      $(row).find("td").eq(1).text(timeTemplate);
    }, 1000);
  },
  columnDefs: [
        { "targets": 0, "name": "number", "title": "番号", "data": 0}, 
        { "targets": 1, "name": "passeTime", "title": "経過時間", "data": 1},
        { "targets": 2, "name": "target", "title": "目標", "data": 2 },   
        { "targets": 3, "name": "goals", "title": "小目標", "data": 3,},   
        { "targets": 4, "name": "archievement", "title": "達成率", "data": 4}    
    ]
});
setTimeout(() => {
  datatable.draw();
}, 1000);

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $(".btn-submit-new-post").on('click',function(e){

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
        createdRowElement+=1;
        $(".form-control").val('');
        buildedHtml = [];
        data[2].forEach((val)=>{
          var html = `<div class="form-check">
                        <input class="form-check-input" type="checkbox" data-id=${val['id']} id="checkbox${val['id']}">
                        <label class="form-check-label" for="checkbox${val['id']}">${val['title']}</label>
                      </div>
                     `
           buildedHtml.push(html);
           
          while(addInputCounter>0){
            $(`.addedGoal${addInputCounter}`).remove();
            addInputCounter -= 1;
          }
          addInputCounter = 1;

        });
        var newRow = datatable.row.add([
            createdRowElement,
            data[0]['created_at'],
            data[0]['title'],
            buildedHtml.join(""),
          `${data[0]['archievement']}%`
        ]);
        datatable.draw();
        $('.error-title').text("");
        $('.error-goal').text("");
      }).fail((response)=>{
        if((validationError = response.responseJSON)){
          $('.error-title').text(validationError.errors['title']);
          $('.error-goal').text(validationError.errors['goal.0']);
        }else{
        location.href = "/";
        }
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
      
      var progress = Math.floor(data[0]['archievement']);
      var button = `
                    <form action="/mypage/compTarget/${data[0]['id']}" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-success btn-comp-target">
                      完了
                    </button>
                    </form>`
      var tasseido = progress !=100 ? progress+'%': button;
      var archievementCell = $(e.target).parent().parent().next();
      datatable.cell(archievementCell).data(tasseido);
    }).fail((response)=>{
      errorRedirect(response.status);
    })
  })
  
</script>
</html>
@endsection