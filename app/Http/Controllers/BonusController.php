<?php

namespace App\Http\Controllers;

use App\Http\Resources\BonusResource;
use App\Models\Bonus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BonusController extends Controller
{
    public function all()
    {       
        //Get Bids
        //$bonuses = Bonus::where('bonuses.status', '>', 0)->get()->sum('amount');

        //return view('allbonuses',['bonuses'=>$bonuses]);
        $bonus = Bonus::orderBy('status','desc')->orderBy('user.username')->get();;
        return view('allbonuses',['bonuses'=>$bonus]);
        
      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //Get Bonus
         $bonuses = Auth::user()->bonuses()->where('status','<>',0)->get();

         return view('bonus',['bonuses'=>$bonuses]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function show(Bonus $bonus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function edit(Bonus $bonus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bonus $bonus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bonus $bonus)
    {
        //
    }
    public function pay(Request $request)
    {
        if (Auth::user()->id == 1) { 
                    $pay= Bonus::findOrFail($request->bonus)->update(['status' => 0]);
                    return redirect('/all-bonuses');
        }  
    }
}
