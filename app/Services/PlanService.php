<?php

namespace App\Services;

use App\Models\Calendar;
use App\Models\Plan;
use App\Models\PlanWeek;
use Carbon\Carbon;

class PlanService
{
    public function store($request,$id)
    {

        $r=$request->all();
        unset($r['_token']);
        date_default_timezone_set('Asia/Tashkent');
        $cal=Calendar::where('year_month','10.2022')->first();
        $arr=json_decode($cal->day_json);

        foreach ($r as $key => $item){
            if($item!=0){
                $plan=$this->save($key,$item,$id);

                $workday=$cal->work_day;
                $count=0;
                $start=0;
                $sikl=0;
                if($workday>0&&$workday<14){
                    $count==1;
                }elseif ($workday>=14&&$workday<=20){
                    $count=2;
                }elseif ($workday>=21&&$workday<=26){
                    $count=3;
                }else{
                    $count=4;
                }
//                dd($plan->number);
                $planwork=$plan->number/$cal->work_day;
                for($i=0;$i<$count;$i++){
                    $pw=new PlanWeek();
                    $pw->plan_id=$plan->id;
                    $pw->user_id=$plan->user_id;
                    if($workday>13){
                        $pw->workday=7;
                        $workday=$workday-7;
                    }else{
                        $pw->workday=$workday;

                    }
                    $ct=0;
                    $cf=0;
                    $l=$pw->workday;
                    for($j=$start;$j<$start+$l;$j++){

                        
                        if($arr[$j]=='true'){
                            $ct++;
                        }else{
                            $cf++;
                            $l++;
                        }

                        if($ct==1){
                            $d=$j;
                            $d=$d.' day';
                            $pw->startday=date("Y-m-d", strtotime($d, strtotime((Carbon::now()->startOfMonth()))));
                        }


                        if($ct==$pw->workday){
                            $d=$j;
                            $start=$j+1;
                            $d=$d.' day';

                            $pw->endday=date("Y-m-d", strtotime($d, strtotime((Carbon::now()->startOfMonth()))));
                            if($i!=$count-1){
                                $pw->plan=round($planwork*$pw->workday);
                            }else{
                                $pw->plan=$plan->number;
                            }

                            $plan->number=$plan->number-$pw->plan;
                            $pw->calendar_id=$cal->id;
                            $pw->save();
                            break;

                        }
                    }

                }




            }
        }
    }

    public function save($key,$item,$id)
    {
        $plan=new Plan();
        $plan->medicine_id= substr($key,8);
        $plan->number=$item;
        $plan->user_id=$id;
        $plan->save();
        return $plan;
    }
}
