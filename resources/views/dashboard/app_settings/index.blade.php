@extends ('dashboard.layouts.master')
@section('title', 'الإعدادات')
@section ('content')
    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0"># الإعدادات</h2>
        </div>

      <div class="form-row">
        <div class="flex-grow-1"></div>
              <div class="m-2">
                <button class="btn btn-primary px-5 settings edit" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> تعديل  <i class="ml-2 fas fa-plus-circle"></i></button>
              </div>
          </div>
        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            @include('dashboard.app_settings.tableInfo')
          </table>
        </div>
    </div>
      @include('dashboard.app_settings.viewModal')
      @include('dashboard.app_settings.addEditModal')
</div>
@push('script')
<script>
  $("body").on("click",".get-record",function(){
    let id = $(this).parents('tr').data("id");
    $.ajax({
      url: "{{Request::segment(2)}}/getRecord/"+id,
      type: 'GET',
      processData: false,
      contentType: false,
      beforeSend: function(){
        $(".addEdit-new-modal .loading-container").toggleClass("d-none d-flix");
      },
      success: function(record) {
        $(".addEdit-new-modal .loading-container").toggleClass("d-none d-flix");
        for (var k in record) {
          if (record.hasOwnProperty(k)) {
            if(k.includes('image')  ){
              $(".carousel-item ."+k).attr("src","{{url('/')}}"+record[k]);
            }else{
              $(".list-group-item ."+k).html(record[k])
            }
          }
        }
      }
    });
  });
  $("body").on("click",".settings",function(){
    $(".addEdit-new-modal .modal-title").html("تعديل الإعدادات ");
    $(".addEdit-new-modal input[name='id']").val("{{$record->id}}");
    $.ajax({
      url: "{{Request::segment(2)}}/getRecord/{{$record->id}}",
      type: 'GET',
      processData: false,
      contentType: false,
      beforeSend: function(){
        $(".addEdit-new-modal .loading-container").toggleClass("d-none d-flix");
      },
      success: function(record) {
        $(".addEdit-new-modal .loading-container").toggleClass("d-none d-flix");
        for (var k in record) {
          if (record.hasOwnProperty(k)) {
            if(k.includes('image')  ){
              $(".carousel-item ."+k).attr("src","{{url('/')}}"+record[k]);
            }else{
              $(".addEdit-new-modal input[name='"+k+"']").val(record[k]);
               $(".addEdit-new-modal textarea[name='"+k+"']").val(record[k]);
            }
          }
        }
      }
    });
  });
  
</script> 
@endpush
@endsection
        