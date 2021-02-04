<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class WithdrawalController extends Controller
{
    public function all()
    {
        //Get Bids
        $withdrawals = Withdrawal::orderBy('status','desc')->latest()->get();;

        return view('withdrawals',['withdrawals'=>$withdrawals]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([            
            'amount'            => 'required|max:10|between:0,99.99', 
            'payment_method' => 'required|integer',
            'investment'     => 'required|integer',               
        ]);
        //Take balance and due date from investments
        $investment     = Investment::where('id',$request->investment)->first();
        $balance        = $investment->balance;
        $due_date       = $investment->due_date;
        $profit         =$investment->profit;

        //------------Start transaction------------------// 
        $amount  = $request->input('amount'); 

        //Daily Minimum and Maximum withdrawal
        $user = Auth::user();    
        $min_amount = 10;
        $max_amount = 15000; 

        //Checking if amount is less than available balance, amount is not zero, investment mature, transaction limit not exceeded or below
        if (($amount <= $balance) && ($amount!=0) && ($due_date < now()) && ($min_amount <= $amount) && ($max_amount >= $amount)) {
            $investment_balance = $balance-$amount;//Calculating balance to remain
            $profit_balance = $profit - $amount;
            
            // //Check if remaining balance can be placed on market place again
            if (($investment_balance < $min_amount) && ($investment_balance != 0) ) {
                return redirect()->back()->withErrors('Take all remaining balance will be less than'. $min_amount);             
            }

            // //Check if amount is bigger than profit
            if ($amount > $profit) {
                return redirect()->back()->withErrors('Amount is bigger than withdrawable profit of '. ($profit+0));             
            }

            //Setting statuses to update investment
            if ($amount == $balance) {
                $status = 0;
            } else {
                $status = 1;
            }
            try {
                DB::beginTransaction();
                $withdrawal                          = new Withdrawal;
                $withdrawal->amount                  = $request->input('amount');             
                $withdrawal->bank_detail_id       = $request->input('payment_method');
                $withdrawal->investment_id           = $request->input('investment');
                $withdrawal->user_id                 = Auth::user()->id;   
                $withdrawal->ipAddress               = request()->ip();  
                $withdrawal->save();
                  
                //Reduce Investment
                $investment                            = Investment::findOrFail($request->input('investment'));
                $investment->balance                   = $investment_balance;
                $investment->profit                    = $profit_balance;
                $investment->status                    = $status;
                $investment->save();   
                DB::commit();
                return redirect()->back()->with('message', 'Withdrawal Successful. Please wait for it to be processed');
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        }
        else{
            return redirect()->back()->withErrors('Amount must be between minimum and maximum daily limit');  
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   
        $bank_details = Auth::user()->bank_details()->get();
        
        if($bank_details->isEmpty()){
            return view('withdraw')->withErrors('Please add payment details first before making withdrawal');
        }
        else{           
            return view('withdraw',['bank_details'=>$bank_details,'investment'=>$request->id]);
        }        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return \Illuminate\Http\Response
     */
    public function edit(Withdrawal $withdrawal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Withdrawal $withdrawal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Withdrawal $withdrawal)
    {
        //
    }
    public function approve(Request $request)
    {
        $request->validate([
            'withdrawal'                  => 'required|integer'
        ]);
            try {
                DB::beginTransaction();
                $approve_payment= Withdrawal::findOrFail($request->withdrawal)->update(['status' => 0]);
                DB::commit();
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }     
    }
}
