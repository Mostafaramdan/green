<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\content\modelContent;
use App\Models\days;
class insertDays extends Command
{
    protected $signature = 'insertDays:go ';

    protected $description = 'insert Days in db';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $days=[
            ["rank"=>0,"name_ar"=>"الأحد"    ,"name_en"=>"Sunday"   ],
            ["rank"=>1,"name_ar"=>"الأثنين"  ,"name_en"=>"Monday"   ],
            ["rank"=>2,"name_ar"=>"الثلاثاء" ,"name_en"=>"Tuesday"  ],
            ["rank"=>3,"name_ar"=>"الأربعاء" ,"name_en"=>"Wednesday"],
            ["rank"=>4,"name_ar"=>"الخميس"  ,"name_en"=>"Thursday" ],
            ["rank"=>5,"name_ar"=>"الجمعة"  ,"name_en"=>"Friday"   ],
            ["rank"=>6,"name_ar"=>"السبت"   ,"name_en"=>"Saturday" ],
        ];
        days::where('id','!=',null)->delete();
        foreach($days as $day){
            days::createUpdate([
                "rank"=>$day['rank'],
                'name_ar'=>$day['name_ar'],
                "name_en"=>$day['name_en']
            ]);
        }
        $this->info("created All days successfully by mostafa ramdan");

    }
    public static function controllerFile($modelName){

    }
}
