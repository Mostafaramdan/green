<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\products as model;
use App\Models\categories ;
use App\Models\images ;
use App\Models\offers ;

class products extends Controller
{
    public static $model;
    function __construct(Request $request)
    {
        self::$model=model::class;
    }
    public static function index()
    {
        $records= self::$model::all();
        $categories = categories::allActive();
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= 1;
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'));
        return view('dashboard.products.index',compact("records","totalPages",'currentPage','categories'));
    }   

    public static function indexPageing(Request $request)
    {
        $sort=$request->sortType??'sortBy';
        $records= self::$model::all()->$sort($request->sortBy??"id",);    
        if($request->search){
            $search= $request->search;
            $records= $records->filter(function($item) use ($search) {
                return stripos($item['name'],$search) !== false;
            });
        }
        if($request->filter){
            if($request->filter == 'falseOffer' ){
                $records= $records->where('hasOffer',false);
            }elseif($request->filter == 'trueOffer' ){
                $records= $records->where('hasOffer',true);
            }
        }
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= $request->currentPage>0?$request->currentPage:1;
        $records=$records->forpage($currentPage,config('helperDashboard.itemPerPage'));
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.products.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request)
    {
        $rules=[
            "name_ar"            =>"required|min:3",
            "name_en"            =>"required|min:3",
            "description_ar"     =>"required|min:3",
            "description_en"     =>"required|min:3",
            "quantity"           =>"required",
            "price_KWD"          =>"required",
            "price_EGP"          =>"required",
            "price_SAR"          =>"required",
            "price_AED"          =>"required",
            "categories_id"      =>"required",
            "serial"             =>"required|unique:products,serial,".$request->id,
            "mainImage"          =>"required_if:id,",
            "image"              =>"required_if:id,|nullabe|min:1",
        ];
        if($request->has('offer')){
            $rules=[
                "discountPercentage" =>"required|numeric|min:1|max:99",
                "maximumDeduction"   =>"required|numeric|min:1",
                "startAt"            =>"required|after:".date("Y-m-d H:i:s"),
                "endAt"              =>"required|after:startAt",
            ];
        }
        $messages=[
        ];

        $messagesAr=[

            "name_ar.required"     =>"يجب ادخال الاسم بالعربي",
            "name_ar.min"          =>"يجب ان لا يقل الاسم بالعربي عن 3 حروف ",

            "name_en.required"     =>"يجب ادخال الاسم بالانجليزي",
            "name_en.min"          =>"يجب ان لا يقل الاسم بالانجليزي عن 3 حروف ",

            "description_ar.required"     =>"يجب ادخال الوصف بالعربي",
            "description_ar.min"          =>"يجب ان لا يقل الوصف بالعربي عن 3 حروف ",

            "description_en.required"     =>"يجب ادخال الوصف بالانجليزي",
            "description_en.min"          =>"يجب ان لا يقل الوصف بالانجليزي عن 3 حروف ",

            "price_KWD.required"     =>"يجب ادخال السعر بالكويتي ",
            "price_EGP.required"     =>"   يجب ادخال السعر بالمصري",
            "price_SAR.required"     =>"يجب ادخال السعر بالسعودي",
            "price_AED.required"     =>"يجب ادخال السعر بالاماراتي",

            "quantity.required"     =>"يجب ادخال الكمية",

            "categories_id.required"     =>"يجب ادخال القسم ",

            "serial.required"     =>"يجب ادخال رقم المسلسل ",
            "serial.unique"     =>"  رقم المسلسل موجود",

            "mainImage.required_if"     =>"يجب ادخال الصورة الرئيسية ",

            "image.required_if"     =>"يجب ادخال صور المنتج  ",
            "image.min"     =>"يجب ادخال صورة واحدة علي الاقل  ",

            "discountPercentage.required"         =>"يجب ادخال نسبة الخصم ",
            "discountPercentage.min"              =>"يجب ادخال  نسبة الخصم بشكل صحيح ",
            "discountPercentage.max"              =>"يجب ادخال  نسبة الخصم بشكل صحيح ",

            "maximumDeduction.required" =>"يجب ادخال اكبر رقم للخصم   ",
            "maximumDeduction.min"      =>" يجب ادخال اكبر رقم للخصم بشكل صحيح   ",

            "startAt.required"     =>"يجب ادخال تاريخ البداية  ",
            "startAt.after"     =>" يجب ادخال تاريخ البداية بعد الوقت الحالي  ",

            "endAt.required"     =>"يجب ادخال تاريخ النهاية  ",
            "endAt.after"     =>" يجب ادخال تاريخ النهاية بعد تاريخ البداية   ",


        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    } 
        if($request->id ){
            if($request->mainImage){
                helper::deleteFile(self::$model::find($request->id)->mainImage);
            }
        }
        $record= self::$model::createUpdate([
            'id'=>$request->id,
            'name_ar'=>$request->name_ar,
            'name_en'=>$request->name_en,
            'description_ar'=>$request->description_ar,
            'description_en'=>$request->description_en,
            'price_KWD'=>$request->price_KWD,  
            'price_EGP'=>$request->price_EGP,  
            'price_SAR'=>$request->price_SAR,  
            'price_AED'=>$request->price_AED,  
            'quantity'=>$request->quantity,  
            'categories_id'=>$request->categories_id,  
            'mainImage'=>$request->mainImage,  
            'serial'=>$request->serial,  
            "isShipment"=>$request->isShipment==="0"?1:0
        ]);
        if($request->image ){
            foreach($request->image as $image){
                images::createUpdate([
                    'image'=>$image,
                    'products_id'=>$record->id
                ]);
            }
        }
        $newOffer= true;
        if($request->has('offer')){
            if($record->offer){
                $offer= $record->offer;
                if($offer->discount == $request->discount && 
                    $offer->maximumDeduction == $request->maximumDeduction && 
                    $offer->startAt == $request->startAt && 
                    $offer->endAt == $request->endAt 
                ){
                    $newOffer=false;
                }else{
                    $offer->is_active= 0;
                    $offer->save();
                    $newOffer=true;
                }
            }else{
                $newOffer=true;
            }
            if ($newOffer){
                offers::createUpdate([
                    'products_id'=>$record->id,
                    "discountPercentage"=>$request->discountPercentage,
                    "maximumDeduction"=>$request->maximumDeduction,
                    "startAt"=>$request->startAt,
                    "endAt"=>$request->endAt,
                ]);

            }
        }

        $message=$request->id?"edited successfully":'added successfully';
        
        return response()->json(['status'=>200,'message'=>$message,'record'=>$record]);
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
        return response()->json(['status',200,'action'=>$action]);
    }
    public static function delete($id)
    {
        $record= self::$model::find($id);
        $record->delete();
        return response()->json(['status'=>200]);
    }
}

