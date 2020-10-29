@extends ('dashboard.layouts.master')
@section('title', ' المنتجات')
@section ('content')

    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0"># المنتجات</h2>
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
                <option value="name_ar">الاسم</option>
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
                <option value="falseOffer">خارج العرض</option>
                <option value="trueOffer">داخل العرض</option>
              </select>
            </div>
        </form>

        <div class="flex-grow-1"></div>
              <div class="m-2">
                <button class="btn btn-primary px-5 add" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> إضافة منتج جديد <i class="ml-2 fas fa-plus-circle"></i></button>
              </div>
          </div>
        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            @include('dashboard.products.tableInfo')
          </table>
        </div>

        <!-- pagination -->
        <div class="paging">  
          @include('dashboard.layouts.paging')
        </div>
        <!-- end pagination -->
    </div>
      <!-- Large modal -->
      @include('dashboard.products.viewModal')
      <!-- end Large modal -->

      <!-- addEdit new modal -->
        @include('dashboard.products.addEditModal')
      <!-- end add user modal -->

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
            if(k.includes('image') || k.includes('mainImage')  ){
              $(".carousel-item ."+k).attr("src","{{url('/')}}"+record[k]);
            }else{
              $(".view-modal ."+k).html(record[k])
            }
          }
        }
        $(".carousel-indicators li").remove();
        $(".carousel-inner img").remove("");
          $(".carousel-indicators ").append(`
            <li data-target="#carouselExampleIndicators" data-slide-to="{{url('/')}}"+${record.image}" class=" bg-primary active" ></li>
          `);
          $(".carousel-inner").append(`
            <div class="carousel-item active">
            <img style="width:75%"
              src="${record.image}"
              class="d-block w-100">
          </div>
          `);

        for (var i=0; i<record.images.length; i++){
          $(".carousel-indicators ").append(`
            <li data-target="#carouselExampleIndicators" data-slide-to="{{url('/')}}"+${i}" class=" bg-primary"></li>
          `);
          $(".carousel-inner").append(`
            <div class="carousel-item ">
            <img style="width:75%"
              src= "${record.images[i].image}"
              class="d-block w-100">
          </div>
          `);
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
            if( k.includes('image') || k.includes('Image')  ){
              if(record[k]){  
                $('img#'+k).attr('src', record[k]).attr("hidden",false);
              }else{
                $('img #'+k).attr("hidden",true);
              }
            }else if(k == 'password'){
              $(".addEdit-new-modal input[name='"+k+"']").val(null);
              continue;
            }else{
              if(k.charAt(0)== 'i' && k.charAt(1)== "s"){
                if( record[k] == 1){
                  $(".addEdit-new-modal input[name='"+k+"']").attr('checked',true);
                }else{
                  $(".addEdit-new-modal input[name='"+k+"']").attr('checked',false);
                }
              }else{
                $(".addEdit-new-modal input[name='"+k+"']").val(record[k]);
                $(".addEdit-new-modal select[name='"+k+"'] option[value='"+record[k]+"']").prop('selected', true);
                
              }
            }
          }
        }
        $('.imageuploadify-container').remove();
        for (var i=0; i<record.images.length; i++){
          $('.imageuploadify-images-list').append(`
            <div class="imageuploadify-container" style="margin-left: 12px;">
              <button type="button" class="btn btn-danger glyphicon glyphicon-remove" onClick="deleteImagefromDragDrop('images',${record.images[i].id},$(this).parent('.imageuploadify-container'));"></button>
              <div class="imageuploadify-details" style="opacity: 0;">
                <span>Capture.PNG</span>
                <span>image/png</span>
                <span>159645</span>
                </div>
                <img src="${record.images[i].image}">
              </div>
          `);
        }
        
        if(record.hasOffer == true){
          $(".offer_Info").removeClass("d-none");
          $("#customCheck1").attr('checked',true);
          $(".addEdit-new-modal input[name='discountPercentage']").val(record.offer.discountPercentage);
          $(".addEdit-new-modal input[name='maximumDeduction']").val(record.offer.maximumDeduction);
          $(".addEdit-new-modal input[name='startAt']").val(record.offer.startAt);
          $(".addEdit-new-modal input[name='endAt']").val(record.offer.endAt);

          
        }else{
          $(".offer_Info").addClass("d-none");
          $("#customCheck1").attr('checked',false);
          $(".addEdit-new-modal input[name='discountPercentage']").val("");
          $(".addEdit-new-modal input[name='maximumDeduction']").val("");
          $(".addEdit-new-modal input[name='startAt']").val("");
          $(".addEdit-new-modal input[name='endAt']").val("");
        }
      }
    });
  });
  $("body").on("click",".add",function(){
    $(".offer_Info").addClass("d-none");
    $("#customCheck1").attr('checked',false);
  });
  $("body").on("click","#customCheck1",function(){
    if(this.checked) {
      $(".offer_Info").removeClass("d-none");
    }else{
      $(".offer_Info").addClass("d-none");
    }
  });

</script> 

@endpush

@endsection
        