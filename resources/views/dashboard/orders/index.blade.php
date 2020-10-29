@extends ('dashboard.layouts.master')
@section('title', ' الطلبات')
@section ('content')
    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0"># الطلبات</h2>
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
                <option value="name">الاسم</option>
                <option value="created_at">تاريخ الانشاء</option>
              </select>
            </div>

            <div class="m-2">
              <select class="custom-select"  name="sortType">
                <option selected disabled>نوع الترتيب</option>
                <option value="sortBy">تصاعدي</option>
                <option value="sortByDesc">تنازلي</option>
              </select>
            </div>
            <div class="m-2">
              <select class="custom-select"  name="filter">
                <option selected disabled>فلتر </option>
                <option value="all">الكل </option>
                <option value="waiting">انتظار </option>
                <option value="accepted">موافقة  </option>
                <option value="onProgress">قيد التنفيذ   </option>
                <option value="delivered">  تم التسليم </option>
              </select>
            </div>

        </form>

        <div class="flex-grow-1"></div>
              <div class="m-2">
              </div>
          </div>
        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            @include('dashboard.orders.tableInfo')
          </table>
        </div>

        <!-- pagination -->
        <div class="paging">  
          @include('dashboard.layouts.paging')
        </div>
        <!-- end pagination -->
    </div>
      <!-- Large modal -->
      @include('dashboard.orders.viewModal')
      <!-- end Large modal -->

      <!-- addEdit new modal -->
        @include('dashboard.orders.addEditModal')
      <!-- end add user modal -->
      @include('dashboard.orders.orderInfoModal')

      <!-- end main content -->
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
        $(".view-modal .map_link").find("a").attr("href",record.mapLink);
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
      }
    });
  });
  $("body").on("click",".orderInfo",function(){
      let id = $(this).parents('tr').data("id");
      $.ajax({
        url: "{{Request::segment(2)}}/getRecordInfo/"+id,
        type: 'GET',
        processData: false,
        contentType: false,
        beforeSend: function(){
          $(".orderInfo-modal .loading-container").toggleClass("d-none d-flix");
        },
        success: function(response) {
          $(".orderInfo-modal .loading-container").toggleClass("d-none d-flix");
          $("table.orderTableInfo").html(response);
        }
      });
  });
</script> 
@endpush
@endsection
        