@extends ('dashboard.layouts.master')
@section('title', ' الأقسام')
@section ('content')
    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0"># الأقسام</h2>
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
            <option value="createdAt">تاريخ الإنشاء</option>
            <option value="nameAr">الاسم</option>
            <option value="country_name">البلد</option>
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
                <button class="btn btn-primary px-5 add" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> إضافة قسم جديد <i class="ml-2 fas fa-plus-circle"></i></button>
              </div>
          </div>
        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            @include('dashboard.categories.tableInfo')
          </table>
        </div>

        <!-- pagination -->
        <div class="paging">  
          @include('dashboard.layouts.paging')
        </div>
        <!-- end pagination -->
    </div>
      <!-- Large modal -->
      @include('dashboard.categories.viewModal')
      @include('dashboard.categories.addEditModal')

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
        $(".view-modal .loading-container").toggleClass("d-none d-flix");
      },
      success: function(record) {
        $(".view-modal .loading-container").toggleClass("d-none d-flix");
        for (var k in record) {
          if (record.hasOwnProperty(k)) {
            if(k.includes('image')  ){
              $(".carousel-item ."+k).attr("src","{{url('/')}}"+record[k]);
            }else{
              $(".view-modal ."+k).html(record[k])
            }
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
                $('img #'+k).attr('src', record[k]).attr("hidden",false);
              }else{
                $('img #'+k).attr("hidden",true);
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
        if(record.country_name){
          $("#customCheck1").attr('checked',false);
          $(".category_id_select").removeClass("d-none");        
        }else{
         $(".category_id_select").addClass("d-none");
         $("#customCheck1").attr('checked',true);
        }
        if(record.hasOffer == true){
          $(".offer_Info").removeClass("d-none");
          $("#customCheck2").attr('checked',true);
          $(".addEdit-new-modal input[name='discountPercentage']").val(record.offer.discountPercentage);
          $(".addEdit-new-modal input[name='maximumDeduction']").val(record.offer.maximumDeduction);
          $(".addEdit-new-modal input[name='startAt']").val(record.offer.startAt);
          $(".addEdit-new-modal input[name='endAt']").val(record.offer.endAt);

          
        }else{
          $(".offer_Info").addClass("d-none");
          $("#customCheck2").attr('checked',false);
          $(".addEdit-new-modal input[name='discountPercentage']").val("");
          $(".addEdit-new-modal input[name='maximumDeduction']").val("");
          $(".addEdit-new-modal input[name='startAt']").val("");
          $(".addEdit-new-modal input[name='endAt']").val("");
        }
      } 
    });
  });
  $("body").on("click","#customCheck1",function(){
    if(this.checked) {
      $(".category_id_select").addClass("d-none");
    }else{
      $(".category_id_select").removeClass("d-none");
    }
  });
  $("body").on("click",".add",function(){
    $(".category_id_select").addClass("d-none");
    $("#customCheck1").attr('checked',true);

    $(".offer_Info").addClass("d-none");
    $("#customCheck2").attr('checked',false);

  });

  $("body").on("click","#customCheck2",function(){
    if(this.checked) {
      $(".offer_Info").removeClass("d-none");
    }else{
      $(".offer_Info").addClass("d-none");
    }
  });
</script> 
@endpush
@endsection
        