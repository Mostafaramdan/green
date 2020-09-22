<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use DB;
use App\Models\users;
use App\Models\providers;
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
        $users = json_encode(self::Query('users'));
        $providers = json_encode(self::Query('providers'));
        return view('dashboard.statistics.index', compact('users','providers'));
    }   

    public static function getByDateRange(Request $request)
    {
        return response()->json([
            'providersCount'=>providers::where('created_at','>=',$request->from??'2000-01-01' )->where('created_at','<=',$request->to??date("Y-m-d") )->count(),
            'usersCount'=>users::where('created_at','>=',$request->from??'2000-01-01' )->where('created_at','<=',$request->to??date("Y-m-d") )->count(),
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