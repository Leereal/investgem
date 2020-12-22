<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bids;
use App\Models\Bonus;
use App\Models\Investment;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BidsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        //Get Bids
        $deposits = Bids::all();

        return view('deposits',['deposits'=>$deposits]);
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
            'pop'               => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'amount'            => 'required|max:10|between:0,99.99|gt:0',
            'payment_method'    => 'required|integer',  
            'plan'              => 'required|integer',
        ]);
       
        $user = auth()->user();      
        $min_amount = 20;
        $max_amount = 20000;

        if ($min_amount <= $request->amount && $max_amount >= $request->amount) { 
            $imageName = time().'.'.$request->pop->extension(); 
            $request->pop->move(public_path('images/pop'), $imageName);    
                try {
                    DB::beginTransaction();
                    $bid                          = new Bids;
                    $bid->amount                  = $request->amount;   
                    $bid->bank_id                 = $request->payment_method;              
                    $bid->plan_id                 = $request->plan;                    
                    $bid->user_id                 = $user->id;
                    $bid->pop                     = $imageName;
                    $bid->ipaddress               = request()->ip();
                    $bid->save();                   
                    DB::commit();
                    return redirect()->back()->with('message', 'Payment submitted please wait for approval or contact support speed up the process');

                } catch (\Exception $e) {
                    DB::rollback();
                    throw $e;
                }  
        } else {
            return redirect()->back()->withErrors('Amount must be between minimum and maximum limit');
        }
    }
    public function approve(Request $request)
    {
        $request->validate([
            'bid'                  => 'required|integer',
        ]);

        //Get pending order with posted id
        $bid = Bids::where('id', $request->bid)->first();

        //Get package of the  pending order
        $plan    = Plan::findOrFail($bid->plan_id);

        //Get receiver details
        $receiver = User::where('id', $bid->user_id)->with('referrer')->first();

        $amount = $bid->amount;
        $expected_profit = $amount + ($plan->interest / 100 * $amount);
        $balance = $expected_profit;

        //Take investment done today by pending order user(buyer)  and with the same package to join with the current one if any
        $investment  = Investment::where('user_id', $bid->user_id)->whereDate('created_at', Carbon::today())->where('plan_id', $bid->plan_id)->where('status', 101)->first();
        //If there was a valid investment done today of the same package from the same user then update it to have one investment
        if ($investment) {
            try {
                DB::beginTransaction();

                $investment->expected_profit += $expected_profit;
                $investment->amount += $amount;
                $investment->balance += $balance;
                $investment->save();

                if ($receiver->referrer_id > 0) {
                    //Add bonus
                    $referral_bonus                      = new Bonus();
                    $referral_bonus->user_id             = $receiver->referrer->id;
                    $referral_bonus->amount              = $bid->amount * 0.08;
                    $investment->bonus()->save($referral_bonus);
                }
                $approve_payment= Bids::findOrFail($request->bid)->update(['status' => 0]);
                DB::commit();
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        } else { // Create new investment
            try {
                DB::beginTransaction();
                //Add Investment
                $investment                          = new Investment;
                $investment->amount                  = $amount;
                $investment->description             = 'Peer to Peer';
                $investment->plan_id                 = $bid->plan_id;              
                $investment->user_id                 = $bid->user_id;               
                $investment->due_date                = Carbon::now()->addDays($plan->period);
                $investment->bank_id                 = $bid->bank_id;         
                $investment->ipaddress               = request()->ip();
                $investment->expected_profit         = $expected_profit;
                $investment->balance                 = $balance;
                $investment->save();

                if ($receiver->referrer_id > 0) {
                    //Add bonus
                    $referral_bonus                      = new Bonus();
                    $referral_bonus->user_id             = $receiver->referrer->id;
                    $referral_bonus->amount              = $bid->amount * 0.08;
                    $investment->bonus()->save($referral_bonus);
                }
                Bids::findOrFail($request->bid)->update(['status' => 0]);
                 DB::commit();           
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        }
    }

}
