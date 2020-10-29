@extends ('dashboard.layouts.master')
@section('title', 'المتاجر')
@section ('content')
    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0">#المتاجر</h2>
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
                <option value="sortBy">تصاعدي </option>
                <option value="sortByDesc">تنازلي</option>
              </select>
            </div>
        </form>
        <div class="flex-grow-1"></div>
              <div class="m-2">
              </div>
          </div>
        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            @include('dashboard.stores.tableInfo')
          </table>
        </div>
        <div class="paging">  
          @include('dashboard.layouts.paging')
        </div>
    </div>
      @include('dashboard.stores.viewModal')
      @include('dashboard.stores.addEditModal')
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
        $(".view-modal .providerName").html(record.provider.name);
        $(".view-modal .providerPhone").html(record.provider.phone);
        $(".view-modal .categoriesName").html(record.categories.name_ar);
        $(".view-modal .levelsName").html(record.levels.name_ar);
        $(".view-modal .fromDay").html(record.from_days.name_ar);
        $(".view-modal .toDay").html(record.to_days.name_ar);
        $(".view-modal .fromTime").html(record.fromTime);
        $(".view-modal .toTime").html(record.toTime);
        $(".view-modal .facebook").html( `<a href=//${record.facebook}>${record.facebook}</a>`);
        $(".view-modal .twitter").html(  `<a href=//${record.twitter}>${record.twitter}</a>`);
        $(".view-modal .instagram").html(`<a href=//${record.instagram}>${record.instagram}</a>`);
        $(".carousel-item .logo").attr("src","{{url('/')}}"+record.logo);
        for (i=0;i<record.images.length;i++){
          $(".carousel-inner").append(`<div class="carousel-item"> <img style="width:75%" 
            src=${record.images[i].includes("http")?record.images[i]:"{{url('/')}}"+record.images[i]} 
            class="d-block w-100"></div>`
          );
          $(".carousel-indicators").append(` 
            <li data-target="#carouselExampleIndicators" data-slide-to=${i+1} class="bg-primary"></li>`
          );
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
      }
    });
  });
</script> 
@endpush
@endsection
        