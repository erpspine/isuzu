<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\shop\Shop;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        public function apiHome()
    {
            
        $master = array();
	$master['shop'] = Shop::where('check_point', 1)
    ->orderBy('shop_no', 'asc')
    ->with(['unitmovement' => function ($q) {
        $q->whereIn('current_shop', function ($subquery) {
            $subquery->select('id')
                     ->from('shops')
                     ->where('check_point', 1);
        });
    }])
    ->get();
        $master['buffer'] = Shop::where([['buffer', 1]])->get();
        return response()->json(['msg' => null, 'data' => $master, 'success' => true], 200);
    }


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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
