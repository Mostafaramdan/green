@extends ('dashboard.layouts.master')
@section('title', 'المسؤولين')
@section ('content')
    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0"># المسؤولين</h2>
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
                <option value="name">الإسم</option>
                <option value="email">البريد الإلكتروني</option>
                <option value="created_at">تاريخ الإنشاء</option>
              </select>
            </div>
            <div class="m-2">
              <select class="custom-select"  name="sortType">
                <option selected disabled>نوع الترتيب</option>
                <option value="sortBy">تصاعدياََ</option>
                <option value="sortByDesc">تنازلياََ</option>
              </select>
            </div>
        </form>

        <div class="flex-grow-1"></div>
              <div class="m-2">
                <button class="btn btn-primary px-5 add" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> أضافة مسؤول جديد<i class="ml-2 fas fa-plus-circle"></i></button>
              </div>
          </div>
          <div class="table-responsive">
            <table class="table bg-light tableInfo" id="tableInfo" dir="rtl">
              @include('dashboard.admins.tableInfo')
            </table>
          </div>
          <div class="paging">  
            @include('dashboard.layouts.paging')
          </div>
        </div>
      @include('dashboard.admins.viewModal')
      @include('dashboard.admins.addEditModal')
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
              $(".addEdit-new-modal select[name='"+k+"'] option[value='"+record[k]+"']").prop('selected', true);
            }
          }
        }
        if(record.isSuperAdmin==1){
          $(".addEdit-new-modal input[name='isSuperAdmin']").attr('checked',true);
          $(".permissions").addClass("d-none");
          $(".addEdit-new-modal input[type='checkbox']").attr("checked",true);
          $(".custom-checkbox").removeClass('d-none');

        }else{
            $(".addEdit-new-modal input[name='isSuperAdmin']").attr('checked',false);
            $(".permissions").removeClass("d-none");
        }

        var permissions= JSON.parse(record.permissions);
        for( var k in permissions){
          for( var k1 in permissions[k]){
            if(k1.includes("view")){
              if(permissions[k][k1] == 0){
                $("#"+k+"_"+k1).parents("td").siblings("td").find(".custom-checkbox").addClass("d-none");
                $("#"+k+"_"+k1).attr('checked',false);
              }else{
                $("#"+k+"_"+k1).parents("td").siblings("td").find(".custom-checkbox").removeClass("d-none");
                $("#"+k+"_"+k1).attr('checked',true);
              }
            }
            $("#"+k+"_"+k1).attr('checked',permissions[k][k1]==1?true:false);
          }
        }
      }
    });
  });

  $("body").on("click",".addEdit-new-modal input[name='isSuperAdmin']",function(){
    if(this.checked)
      $(".permissions").addClass("d-none");
    else{
      $(".permissions").removeClass("d-none");
    }
  });

  $("body").on("click",".add",function(){
    $(".addEdit-new-modal input[type='checkbox']").attr("checked",true);
    $(".custom-checkbox").removeClass('d-none');
  });

  $("body").on("click",".addEdit-new-modal input[type='checkbox']",function(){
    var name = $(this).attr("name");
    if(name.includes('view') ){
      if(!this.checked){
        $(this).parents("td").siblings("td").find(".custom-checkbox").addClass("d-none");
      }else{
        $(this).parents("td").siblings("td").find(".custom-checkbox").removeClass("d-none");
      }
    }
  });
</script> 
@endpush
@endsection
        