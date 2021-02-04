<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Investment;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        //Get Bids
        $investments = Investment::orderBy('status')->orderBy('due_date')->whereIn('status',[1,101])->get();

        return view('allinvestments',['investments'=>$investments]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get Investments
        $investments = Auth::user()->investments()->where('status','<>',0)->get();

        return view('investments',['investments'=>$investments]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plans = $plans = Plan::all();
        $banks = Bank::all();
        return view('invest',['plans'=>$plans, 'banks'=>$banks]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function show(Investment $investment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function edit(Investment $investment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Investment $investment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Investment $investment)
    {
        //
    }

    public function mature_or_reinvest(Request $request)
    {
        if (Auth::user()->id == 1) {
                $request->validate([
                'investment'                  => 'required|integer'
            ]);
            //Take investment
            $investment = Investment::findOrFail($request->investment);

            //Check if it is a reinvest else mature it              
            if($investment->status == 1){
                //Reinvest
                $this->reinvest($investment->id);
                return redirect('/all-investments');
            }
            if($investment->status == 101){                
                //Mature
                $this->mature($investment->id);
                return redirect('/all-investments');
                
            }
        } 
        else{
            dd('You are trying to hack this lol hahaha') ; 
        } 
    }

    protected function mature($id)
    {
        if (Auth::user()->id == 1) {                
                try {
                    DB::beginTransaction();
                    $mature= Investment::findOrFail($id)->update(['status' => 1]);
                    DB::commit();         
                } catch (\Exception $e) {
                    DB::rollback();
                    throw $e;
                }
        }  
    }
    protected function reinvest($id)
    {
        if (Auth::user()->id == 1) {          
                //Take the whole invest
                $reinvestment = Investment::findOrFail($id);


                //Create new table with new duedate and plan            
                try {
                    DB::beginTransaction();
                        $investment                          = new Investment;
                        $investment->amount                  = $reinvestment->amount;
                        $investment->description             = 'Reinvest';
                        $investment->plan_id                 = $reinvestment->plan_id;              
                        $investment->user_id                 = $reinvestment->user_id;               
                        $investment->due_date                = Carbon::parse($reinvestment->due_date)->addDays($reinvestment->plan->period);
                        $investment->bank_id                 = $reinvestment->bank_id;         
                        $investment->ipaddress               = request()->ip();
                        $investment->expected_profit         = $reinvestment->expected_profit;
                        $investment->profit                  = $reinvestment->expected_profit-$reinvestment->amount;
                        $investment->balance                 = $reinvestment->expected_profit;
                        $investment->save();
                        Investment::findOrFail($reinvestment->id)->update(['status' => 0,'balance'=>0]);
                    DB::commit();                    
                } catch (\Exception $e) {
                    DB::rollback();
                    throw $e;
                }
        }    
    }
}
