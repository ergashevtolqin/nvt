<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Medicine;
use App\Models\Plan;
use App\Models\PlanWeek;
use App\Models\ProductSold;
use App\Models\Sold;
use App\Services\PlanService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
//     *
     */
    public $service;

    public function __construct(PlanService $service)
    {
        $this->service=$service;
    }
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create($id)
    {
        $med=Medicine::all();

        $plans=Plan::where('user_id',$id)->get();

        return view('plan.create',[
            'user_id'=>$id,
            'plans'=>$plans,
            'medicines'=>$med
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(Request $request,$id)
    {
        $this->service->store($request, $id);
        return route('elchi',['id'=>$id,'time'=>'today']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *'number',
    'medicine_id',
    'user_id',
    'order_id',
    'price_product'
     * date("Y-m-d", strtotime($d, strtotime((Carbon::now()->startOfMonth()))));
     */
    public function show($id,$startday)
    {
//        $d=Sold::all();
//        foreach($d as $item){
//            Sold::where('user_id',$id)->delete();
//        }
//        return 'aa';
//        $ps=ProductSold::whereNotNull('user_id')->whereNotNull('order_id')->whereBetween('created_at', [date("Y-m-d", strtotime('-1 month', strtotime((Carbon::now()->startOfMonth())))), date("Y-m-d", strtotime('-1 month', strtotime((Carbon::now()->endOfMonth()))))])->get();
//        foreach ($ps as $item){
//            $sold=new Sold();
//            $item->created_at=date("Y-m-d", strtotime('1 month', strtotime(($item->created_at))));
////            dd($item->user_id);
//            $sold->number=$item->number;
//            $sold->created_at=$item->created_at;
//            $sold->medicine_id=$item->medicine_id;
//            $sold->user_id=$item->user_id;
//            $sold->order_id=$item->order_id;
//            $sold->price_product=$item->price_product;
//            $sold->is_active=$item->is_active;
//            $sold->save();
//        }

        dd($id);

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     */
    public function edit($id)
    {
//        $d=Plan::all();
//        foreach($d as $item){
//            Plan::where('user_id',$id)->delete();
//        }
//        return 'aa';
        $med=Medicine::all();
        $plans=Plan::where('user_id',$id)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
//        dd($plans);
        return view('plan.edit',[
           'user_id'=>$id,
           'plans'=>$plans,
           'medicines'=>$med
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     */
    public function update(Request $request, $id)
    {
        $r=$request->all();
        unset($r['_token']);

        foreach ($r as $key => $item){
            $plan=Plan::where('user_id',$id)
                ->where('medicine_id',substr($key,8))
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->first();
            if (isset($plan)){
            $plan->medicine_id= substr($key,8);
            $plan->number=$item;
            $plan->user_id=$id;

            $plan->update();}
            elseif ($item!=null){
                $plan=new Plan();

                if($item!=0){
                    $plan->medicine_id= substr($key,8);
                    $plan->number=$item;
                    $plan->user_id=$id;
                    $plan->save();
                }
            }
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     */
    public function destroy($id)
    {
        //
    }
}
