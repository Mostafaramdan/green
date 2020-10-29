@extends ('dashboard.layouts.master')
@section('title', 'التقارير')
@section ('content')
    <div class="content" >
      <div  id="alert">
      </div>
      <div class="d-flex align-items-center mb-4">
        <h2 class="m-0"># التقارير</h2>
      </div>
      <form class="mb-4" id="getOptions">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-row"> 
          <div class="m-2">
            <label> من : </label>
            <input type="date" name="fromDate" class="form-control" placeholder="Search">
          </div>
          <div class="m-2">
            <label> إلي : </label>
            <input type="date" name="toDate" class="form-control" placeholder="Search">
          </div>
          <div  style="margin-top:40px">
            <a class="btn btn-primary text-white getByRang mt" > ارسال</a>
          </div>
      </form>  
    </div>
    <div class="row mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
          <div class="card-header align-items-center font-weight-bold">
            أجمالي المستخدمين
            <i class="fas fa-users mr-2 fa-2x "></i>
          </div>
          <div class="card-body">
            <h5 class="card-title usersCount">{{$usersCount}}   </h5>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
          <div class="card-header align-items-center font-weight-bold">
            أجمالي الزوار
            <i class="fas fa-users mr-2 fa-2x "></i>
          </div>
          <div class="card-body">
            <h5 class="card-title usersCount">{{$visitoresCount}}   </h5>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
          <div class="card-header align-items-center font-weight-bold">
            أجمالي الطلبات
            <i class="fas fa-users mr-2 fa-2x "></i>
          </div>
          <div class="card-body">
            <h5 class="card-title usersCount">{{$ordersCount}}   </h5>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
          <div class="card-header align-items-center font-weight-bold">
            أجمالي الطلبات المكتملة
            <i class="fas fa-users mr-2 fa-2x "></i>
          </div>
          <div class="card-body">
            <h5 class="card-title usersCount">{{$completedOrdersCount}}   </h5>
          </div>
        </div>
      </div>
    </div>
    <div class="row" style="margin-bottom: 20px">
        <div class="col-sm-12">
            <canvas id="Chart"></canvas>
        </div>
      </div>  
</div>
@push('script')
<script src="{{ asset('dashboard/chart.js') }}"></script>
<script src="{{ asset('dashboard/sam.js') }}"></script>
<script>
    var ctx = document.getElementById('Chart').getContext('2d');
    var labels = [
        '0',
        'يناير',
        'فبراير',
        'مارس',
        'ابريل',
        'مايو',
        'يونيو',
        'يوليو',
        'أغسطس',
        'سيبتمبر',
        'أكتوبر',
        'نوفمبر',
        'ديسمبر',
    ];

    var datasets = [
      { 
          fill: false,
          label: 'إجمالي المستخدمين ',
          data: sam.fillTheMissedMonthes({!! $users !!}, true),
          backgroundColor: 'rgb(0,123,255)',
          borderColor: 'rgb(0,123,255)',
          borderWidth: 3
        },{ 
          fill: false,
          label: 'إجمالي الزوار ',
          data: sam.fillTheMissedMonthes({!! $visitors !!}, true),
          backgroundColor: 'rgb(255,193,7)',
          borderColor: 'rgb(255,193,7)',
          borderWidth: 3
        },
        { 
          fill: false,
          label: 'إجمالي الطلبات ',
          data: sam.fillTheMissedMonthes({!! $orders !!}, true),
          backgroundColor: 'rgb(220,53,69)',
          borderColor: 'rgb(220,53,69)',
          borderWidth: 3
        },
        { 
          fill: false,
          label: 'إجمالي الطلبات المكتملة ',
          data: sam.fillTheMissedMonthes({!! $completedOrders !!}, true),
          backgroundColor: 'rgb(40,167,69)',
          borderColor: 'rgb(40,167,69)',
          borderWidth: 3
        }
    ];
    var title =  "الإجمالي";
    sam.loadMultiLineChart(ctx, labels, datasets, title);
    $("body").on("click",".getByRang",function(){
      var data = new FormData();
      data.append('from',$("#getOptions input[name='fromDate']").val());
      data.append('to',$("#getOptions input[name='toDate']").val());
      data.append('_token', $('input[name=_token]').val());
      $.ajax({
        url: "{{Request::segment(2)}}/getByDateRange",
        type: 'POST',
        data:data,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $(".loading-container").toggleClass("d-none d-flix");
        },
        success: function(record) {
          $(".loading-container").toggleClass("d-none d-flix");
          $(".usersCount").html(record.usersCount);
          $(".visitoresCount").html(record.visitoresCount);
          $(".ordersCount").html(record.ordersCount);
          $(".completedOrdersCount").html(record.completedOrdersCount);
        }
      });
    });
</script>
@endpush
@endsection
        