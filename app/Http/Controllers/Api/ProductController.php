<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\packaginglist\PackagingList;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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

    public function validateproduct($case_number)
    {
        $master = array();
        $list = PackagingList::where('case_number', '' . $case_number . '')->whereNull('qty_confirmed')->first();
      
        if ($list) {
            $master['case_number'] = $list->case_number;
            return response()->json(['msg' => null, 'data' => $master, 'success' => true], 200);
        }else{
 
            return response()->json(['msg' => null, 'data' => null, 'success' => false], 200);

        }
      
    }
	  public function listproductsscanned($case_number)
    {

    	$data = PackagingList::where('case_number', '' . $case_number . '')->whereNull('qty_confirmed')->get();
    	return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);

    }
}
