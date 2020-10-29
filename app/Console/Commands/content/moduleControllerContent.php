<?php

namespace App\Console\Commands\content;
use Illuminate\Support\Str;

class modueControllerContent
{
  
    public static function Controller ( $fileName){

        return 
'<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\\'.$fileName.' as model;

class '.$fileName.' extends Controller
{
    public static $model;
    function __construct(Request $request)
    {
        self::$model=model::class;
    }
    public static function index()
    {
        $records= self::$model::all();
        $totalPages= ceil($records->count()/config(\'helperDashboard.itemPerPage\'));
        $currentPage= 1;
        $records=$records->forpage(1,config(\'helperDashboard.itemPerPage\'));
        return view(\'dashboard.'.$fileName.'.index\',compact("records","totalPages",\'currentPage\'));
    }   

    public static function indexPageing(Request $request)
    {
      $sort=$request->sortType??\'sortBy\';
      $records= self::$model::all()->$sort($request->sortBy??"id",);    if($request->search){
            $search= $request->search;
            $records= $records->filter(function($item) use ($search) {
                    return stripos($item[\'name\'],$search) !== false;
                });
        }
        $totalPages= ceil($records->count()/config(\'helperDashboard.itemPerPage\'));
        $currentPage= $request->currentPage>0?$request->currentPage:1;
        $records=$records->forpage($currentPage,config(\'helperDashboard.itemPerPage\'));
        $paging= (string) view(\'dashboard.layouts.paging\',compact(\'totalPages\',\'currentPage\'));
        $tableInfo= (string) view(\'dashboard.'.$fileName.'.tableInfo\',compact(\'records\'));
        return [\'paging\'=>$paging,\'tableInfo\'=>$tableInfo];
    }

    public static function createUpdate(Request $request)
    {
        $rules=[
            "name"     =>"required|min:3",
            "email"    =>"required_if:phone,|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:users,email",
            "phone"    =>"required_if:email,|numeric|between:100000000000,99999999999999999999|unique:users,phone",
            \'regionId\' =>"required|exists:regions,id|",
            "password" =>"required|min:6",
        ];

        $messages=[
        ];

        $messagesAr=[

            "name.required"     =>"يجب ادخال الاسم",
            "name.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",

            "email.required_if" =>"يجب ادخال رقم التليفون او البريد الالكتوني",
            "email.regex"       =>"يجب ادخال البريد الالكتروني بشكل صحيح",
            "email.min"         =>"يجب ان لا يقل البريد الالكتروني عن 5 حروف ",
            "email.unique"      =>"هذا البريد مسجل مسبقا",

            "phone.required_if" =>"يجب ادخال رقم التليفون او البريد الالكتروني",
            "phone.nemeric"     =>"يجب ادخال رقم التليفون بشكل صحيح ",
            "phone.between"     =>"يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",
            "phone.unique"      =>"هذا الهاتف مسجل مسبقا",
            
            "regionId.required" =>"يجب ادخال البلد ",
            "regionId.exists"   =>"هذا الرقم غير مسجل في قاعدة البيانات",

            "password.required" =>"يجب ادخال الرقم السري",
            "password.min"      =>"يجب ان لا يقل الرقم السري عن 6 ارقام او حروف",

        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?\'showAllErrors\':\'Validator\';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,\'en\'?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    
        $record= self::$model::createUpdate([
            \'id\'=>$request->id,
            \'name\'=>$request->name,
            \'regions_id\'=>$request->regionId,
            \'email\'=>$request->email,
            \'phone\'=>$request->phone,
            \'password\'=>$request->password,
            \'image\'=>$request->image,  
            \'is_android\'=>1, 
            \'is_online\'=>0, 
        ]);

        $message=$request->id?"edited successfully":\'added successfully\';
        
        return response()->json([\'status\'=>200,\'message\'=>$message,\'record\'=>$record]);
    }

    public static function getRecord($id)
    {
        return  self::$model::find($id);
    }
    public static function check($type, $id)
    {
        $record= self::$model::find($id);
        if($record->$type){
            $action="false";
            $record->$type=0;
        }else{
            $action="true";
            $record->$type=1;
        }
        $record->save();
        return response()->json([\'status\',200,\'action\'=>$action]);
    }
    public static function delete($id)
    {
        $record= self::$model::find($id);
        $record->delete();
        return response()->json([\'status\'=>200]);
    }
}

'; 
    }
    public static function  addEditModalBladeContent ( $fileName){

        return 
'<div class="modal fade addEdit-new-modal" id="addEdit-new-modal" tabindex="-1" role="dialog" aria-labelledby="addEdit-new-modal"aria-hidden="true">
    <div class="loading-container"  >
      <div class="spinner-border text-primary" role="status">
      </div>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  id="createUpdate" action="{{route(\'dashboard.\'.Request::segment(2).\'.createUpdate\')}}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="">
                <div class="form-group">
                        <label for="name" class="col-form-label">الاسم:</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">البريد الالكتروني :</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">رقم التليفون:</label>
                        <input type="text" class="form-control" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label">الرقم السري:</label>
                        <input type="text" class="form-control" name="password">
                    </div>
                    <div class="form-group" >
                        <label for="regionId" class="col-form-label">اختر المدينة:</label>
                        <select  class="form-control" name="regionId">
                            @foreach(\App\Models\regions::where(\'regions_id\',\'!=\',null)->get() as $region)
                                <option value="{{$region->id}}">{{$region->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select multiple data-role="tagsinput" >
                        <option value="Amsterdam">Amsterdam</option>
                        <option value="Washington">Washington</option>
                        <option value="Sydney">Sydney</option>
                        <option value="Beijing">Beijing</option>
                        <option value="Cairo">Cairo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text"  class="form-control" data-role="tagsinput">
                    </div>
                    <div class="row mr-10" >
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary " onClick="event.preventDefault();$(this).parents(\'.row\').find(\'input:file\').click();">اختر صورة <i class="fas fa-image"></i></button>
                        </div>
                        <div class="col-md-12">
                          <input type="file" id="img"  accept="image/*" hidden data-image="image" >
                          <input type="hidden"  name="image" hidden  >
                          <img id="image" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                          <hr/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="image">اختر الصور </label>
                            <input type="file" id="image" name="image[]" accept="image/*" multiple max="15">
                        </div>
                    </div>
                    <div class="form-group" >
                        <div class="progress " >
                            <div class="progress-bar"  role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div> 
                    </div>
                </form>
                <div class="alert " >
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button"  class="btn btn-success submit" id="submit">save</button>
            </div>

        </div>
    </div>
</div>
</div>';
    }
    public static function  indexBladeContent ( $fileName){
        return 
'@extends (\'dashboard.layouts.master\')
@section(\'title\', \''.$fileName.'\')
@section (\'content\')
    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0">#'.ucwords(str_replace('_', ' ', $fileName)).'</h2>
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
        </form>

        <div class="flex-grow-1"></div>
              <div class="m-2">
                <button class="btn btn-primary px-5 add" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> إضافة  '.ucwords(Str::singular(str_replace('_', ' ', $fileName))).' <i class="ml-2 fas fa-plus-circle"></i></button>
              </div>
          </div>
        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            @include(\'dashboard.'.$fileName.'.tableInfo\')
          </table>
        </div>

        <!-- pagination -->
        <div class="paging">  
          @include(\'dashboard.layouts.paging\')
        </div>
        <!-- end pagination -->
    </div>
      <!-- Large modal -->
      @include(\'dashboard.'.$fileName.'.viewModal\')
      <!-- end Large modal -->

      <!-- addEdit new modal -->
        @include(\'dashboard.'.$fileName.'.addEditModal\')
      <!-- end add user modal -->

      <!-- end main content -->
</div>
@push(\'script\')
<script>
  $("body").on("click",".get-record",function(){
    let id = $(this).parents(\'tr\').data("id");
    $.ajax({
      url: "{{Request::segment(2)}}/getRecord/"+id,
      type: \'GET\',
      processData: false,
      contentType: false,
      beforeSend: function(){
        $(".view-modal .loading-container").toggleClass("d-none d-flix");
      },
      success: function(record) {
        $(".view-modal .loading-container").toggleClass("d-none d-flix");
        for (var k in record) {
          if (record.hasOwnProperty(k)) {
            if(k.includes(\'image\')  ){
              $(".carousel-item ."+k).attr("src","{{url(\'/\')}}"+record[k]);
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
    $(".addEdit-new-modal input[name=\'id\']").val($(this).parents("tr").data("id"));
    let id = $(this).parents(\'tr\').data("id");
    $.ajax({
      url: "{{Request::segment(2)}}/getRecord/"+id,
      type: \'GET\',
      processData: false,
      contentType: false,
      beforeSend: function(){
        $(".addEdit-new-modal .loading-container").toggleClass("d-none d-flix");
      },
      success: function(record) {
        $(".addEdit-new-modal .loading-container").toggleClass("d-none d-flix");
        for (var k in record) {
          if (record.hasOwnProperty(k)) {
            if( k.includes(\'image\') || k.includes(\'Image\')  ){
              if(record[k]){  
                $(\'img#\'+k).attr(\'src\', record[k]).attr("hidden",false);
              }else{
                 $(\'img #\'+k).attr("hidden",true);
              }
            }else if(k == \'password\'){
              $(".addEdit-new-modal input[name=\'"+k+"\']").val(null);
              continue;
            }else{
              if(k.charAt(0)== \'i\' && k.charAt(1)== "s"){
                if( record[k] == 1){
                  $(".addEdit-new-modal input[name=\'"+k+"\']").attr(\'checked\',true);
                }else{
                  $(".addEdit-new-modal input[name=\'"+k+"\']").attr(\'checked\',false);
                }
              }else{
                $(".addEdit-new-modal input[name=\'"+k+"\']").val(record[k]);
                $(".addEdit-new-modal select[name=\'"+k+"\'] option[value=\'"+record[k]+"\']").prop(\'selected\', true);
                
              }
            }
          }
        }
        $(\'.imageuploadify-container\').remove();
        for (var i=0; i<record.images.length; i++){
          $(\'.imageuploadify-images-list\').append(`
            <div class="imageuploadify-container" style="margin-left: 12px;">
              <button type="button" class="btn btn-danger glyphicon glyphicon-remove"data-table=\'images\' data-id="${record.images[i].id}" onClick="deleteImagefromDragDrop()"></button>
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
          $("#customCheck1").attr(\'checked\',true);
          $(".addEdit-new-modal input[name=\'discountPercentage\']").val(record.offer.discountPercentage);
          $(".addEdit-new-modal input[name=\'maximumDeduction\']").val(record.offer.maximumDeduction);
          $(".addEdit-new-modal input[name=\'startAt\']").val(record.offer.startAt);
          $(".addEdit-new-modal input[name=\'endAt\']").val(record.offer.endAt);

          
        }else{
          $(".offer_Info").addClass("d-none");
          $("#customCheck1").attr(\'checked\',false);
          $(".addEdit-new-modal input[name=\'discountPercentage\']").val("");
          $(".addEdit-new-modal input[name=\'maximumDeduction\']").val("");
          $(".addEdit-new-modal input[name=\'startAt\']").val("");
          $(".addEdit-new-modal input[name=\'endAt\']").val("");
        }
      }
    });
  });
</script> 
@endpush
@endsection
        ';
    }
    public static function  viewModalBladeContent ( $fileName){
        return 
'<div class="modal fade view-modal" id="view-modal" tabindex="-1" role="dialog"
aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
<div class="loading-container"  >
        <div class="spinner-border text-primary" role="status">
        </div>
    </div>
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalScrollableTitle">Modal title</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active bg-primary"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img style="width:75%"
              src="https://images.unsplash.com/photo-1479231233972-e184fe70398e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=600&q=60"
              class="d-block w-100 image" >
          </div>
          <a class="carousel-control-prev " href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon bg-primary" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next " href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon bg-primary" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
      <h5 class="text-muted mt-3 mb-2">التفاصيل</h5>
      <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          الإسم
          <span class="name"></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          التليفون
          <span class="phone">2</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          البريد الالكتورني 
          <span class="email">2</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          المنطقة
          <span class="region_name">1</span>
        </li>
      </ul>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>';
    }
    public static function tableInfoBladeContent ( $fileName){
return 
'<thead class="thead-dark">
<tr>
<th scope="col">الاسم</th>
<th scope="col">وقت الإنشاء</th>
<th scope="col">التفعيل</th>
<th scope="col"></th>
</tr>
</thead>
<tbody>
@foreach($records as $record)
    <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
        <td>{{$record->name}}</td>
        <td>{{Carbon\Carbon::parse($record->created_at)->toDayDateTimeString()}}</td>
        <td>
            <!-- custom checkbox -->
            <label class="slider-check-box" >
                <input type="checkbox" name="checkbox" @if($record->is_active) checked @endif data-type="is_active">
                <span class="check-box-container d-inline-block" >
                    <span class="circle"></span>
                </span>
            </label>
            <!-- end custom checkbox -->
        </td>
        <td>
          <button class="btn-sm btn btn-danger mb-1"  data-toggle="modal" data-target="#delete-modal"   onClick=\'deleteRecord("{{$record->id}}")\'><i class="fas fa-trash"></i></button>
          <button class="btn-sm btn btn-success edit mb-1" data-toggle="modal" data-target="#addEdit-new-modal"><i class="fas fa-edit"></i></button>
          <button class="btn-sm btn btn-primary get-record mb-1" data-toggle="modal" data-target="#view-modal"><i class="fas fa-eye"></i></button>
        </td>
    </tr>
@endforeach
</tbody>
';
    }
}
