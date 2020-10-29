<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use DB;
use App\Models\users;
use App\Models\orders;
use Carbon\Carbon;
class statistics extends Controller
{
public static $model;
    function __construct(Request $request)
    {
        // self::$model=model::class;
    }
    public static function index()
    {
        $orders =  json_encode(DB::table('orders')
                                        ->select(
                                            DB::raw('COUNT(id) as `value`'),
                                            DB::raw("MONTH(created_at) as `month`")
                                        )
                                        ->where(DB::raw("YEAR(created_at)"), '=', date('Y'))
                                        ->groupBy('month')
                                        ->get());
        $users =  json_encode(DB::table('users')
                                        ->select(
                                           DB::raw('COUNT(id) as `value`'),
                                           DB::raw("MONTH(created_at) as `month`")
                                       )
                                       ->where(DB::raw("YEAR(created_at)"), '=', date('Y'))
                                       ->where('phone', '!=', null)
                                       ->groupBy('month')
                                       ->get());
        $completedOrders =  json_encode(DB::table('orders')
                                       ->select(
                                          DB::raw('COUNT(id) as `value`'),
                                          DB::raw("MONTH(created_at) as `month`")
                                      )
                                      ->where(DB::raw("YEAR(created_at)"), '=', date('Y'))
                                      ->where('status',  'delivered')
                                      ->groupBy('month')
                                      ->get());
        $visitors =  json_encode(DB::table('users')
                                      ->select(
                                         DB::raw('COUNT(id) as `value`'),
                                         DB::raw("MONTH(created_at) as `month`")
                                     )
                                     ->where(DB::raw("YEAR(created_at)"), '=', date('Y'))
                                     ->where('phone',  null)
                                     ->groupBy('month')
                                     ->get());

        $usersCount=users::where('phone','!=',null)->count();
        $visitoresCount=users::where('phone',null)->count();
        $ordersCount=orders::count();
        $completedOrdersCount=orders::where('status',  'delivered')->count();

        return view('dashboard.statistics.index', compact('users','orders','completedOrders','visitors',
                                                          'usersCount','ordersCount','visitoresCount','completedOrdersCount'
                                                                ));
    }   

    public static function getByDateRange(Request $request)
    {
        return response()->json([
            'usersCount'=>users::where('phone','!=',null)->where('created_at','>=',$request->from??'2000-01-01' )->where('created_at','<=',$request->to??date("Y-m-d") )->count(),
            'visitoresCount'=>users::where('phone',null)->where('created_at','>=',$request->from??'2000-01-01' )->where('created_at','<=',$request->to??date("Y-m-d") )->count(),
            'ordersCount'=>orders::where('status',  'delivered')->where('created_at','>=',$request->from??'2000-01-01' )->where('created_at','<=',$request->to??date("Y-m-d") )->count(),
            'completedOrdersCount'=>orders::where('created_at','>=',$request->from??'2000-01-01' )->where('created_at','<=',$request->to??date("Y-m-d") )->count(),
        ]);
    }

    private  static function Query($tableNAme)
    {
        return DB::table($tableNAme)
            ->select(
                DB::raw('COUNT(id) as `value`'),
                DB::raw("MONTH(created_at) as `month`")
            )
            ->where(DB::raw("YEAR(created_at)"), '=', date('Y'))
            ->groupBy('month')
            ->get();
    }
   
}