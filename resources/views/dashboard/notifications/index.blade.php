@extends ('dashboard.layouts.master')
@section('title', 'الإشعارات')
@section ('content')
    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0"># الإشعارات</h2>
        </div>
        <form class="mb-4" id="getOptions">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-row">
          <div class="m-2">
            <input type="search" class="form-control" placeholder="بحث" name="search">
          </div>
          <div class="m-2">
            <select class="custom-select" name="sortBy">
              <option selected disabled>ترتيب علي حسب</option>
              <option value="content_ar"> محتوي الأشعار بالعربي</option>
              <option value="content_en"> محتوي الأشعار بالانجليزية</option>
              <option value="created_at">تاريخ الإنشاء</option>
            </select>
          </div>
          <div class="m-2">
            <select class="custom-select"  name="sortType">
              <option selected disabled>نوع الترتيب</option>
              <option value="asc">تصاعدياََ</option>
              <option value="desc">تنازلياََ</option>
            </select>
          </div>
        </form>
        <div class="flex-grow-1"></div>
            <div class="m-2">
              <button class="btn btn-primary px-5 add" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> إضافة إشعار جديد <i class="ml-2 fas fa-plus-circle"></i></button>
            </div>
        </div>
        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            @include('dashboard.notifications.tableInfo')
          </table>
        </div>
        <div class="paging">  
          @include('dashboard.layouts.paging')
        </div>
    </div>
    @include('dashboard.notifications.viewModal')
    @include('dashboard.notifications.addEditModal')
</div>
@push('script')
<script>
  $("body").on("click",".get-record",function(){
    let id = $(this).parents('tr').data("id");
    $.get( "{{Request::segment(2)}}/getRecord/"+id,function( record ) {
      for (var k in record) {
        if (record.hasOwnProperty(k)) {
          if(k.includes('image')  ){
            $(".carousel-item ."+k).attr("src",record[k]);
          }else{
            $(".list-group-item ."+k).html(record[k])
          }
        }
      }
    });
  });
  $("body").on("click",".edit",function(){
    $(".addEdit-new-modal .modal-title").html("تعديل ");
    $(".addEdit-new-modal input[name='id']").val($(this).parents("tr").data("id"));
    let id = $(this).parents('tr').data("id");
    $.get( "{{Request::segment(2)}}/getRecord/"+id,function( record ) {
      for (var k in record) {
        if (record.hasOwnProperty(k)) {
          if(k.includes('image')  ){
            if(record[k]){  
              $('#'+k).attr('src', record[k]).attr("hidden",false);
            }else{
              $('#'+k).attr("hidden",true);
            }
          }else if(k == 'password'){
            $(".addEdit-new-modal input[name='"+k+"']").val(null);
            continue;
          }else{
            $(".addEdit-new-modal input[name='"+k+"']").val(record[k]);
            $(".addEdit-new-modal textarea[name='"+k+"']").val(record[k]);
            $(".addEdit-new-modal select[name='"+k+"'] option[value='"+record[k]+"']").prop('selected', true);
          }
        }
      }
      if(!record.notification_type){
        $("#customCheck1").attr('checked',true);
        $(".usersTypeSelect").addClass("d-none");

      }else{
        $("#customCheck1").attr('checked',false);
        $(".usersTypeSelect").removeClass("d-none");
        $(".addEdit-new-modal .usersTypeSelect option[value='"+record.notification_type+"']").prop('selected', true);
      }
    });
  });
  $("body").on("click","#customCheck1",function(){
    if(this.checked) {
      $(".usersTypeSelect").addClass("d-none");
    }else{
      $(".usersTypeSelect").removeClass("d-none");
    }
  });
  $("body").on("click",".add",function(){
    $("#customCheck1").attr("checked",true);
    $(".usersTypeSelect").addClass("d-none");
  });

</script> 
@endpush
@endsection
        