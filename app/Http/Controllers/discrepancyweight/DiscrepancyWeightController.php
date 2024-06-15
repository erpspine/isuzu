<?php

namespace App\Http\Controllers\discrepancyweight;

use App\Http\Controllers\Controller;
use App\Models\discrepancyweight\DiscrepancyWeight;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscrepancyWeightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (request()->ajax()) {
                $category = DiscrepancyWeight::get();
                return DataTables::of($category)
                    ->addColumn('action', function ($category) {
                        return '
                        <div class="btn-group">
                        <button type="button" class="btn btn-dark dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ti-settings"></i>
                        </button>
                        <div class="dropdown-menu animated slideInUp"
                            x-placement="bottom-start"
                            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">
                            <a class="dropdown-item" href="javascript:void(0)"><i
                                    class="ti-eye"></i> Open</a>
                            <a class="dropdown-item" href="'.route('decrepancy_weight.edit',[$category->id]).'"><i
                                    class="ti-pencil-alt"></i> Edit</a>
                            <a class="dropdown-item delete_brand_button delete-tcm" href="'.route('decrepancy_weight.destroy', [$category->id]).'"><i
                                    class="ti-trash"></i> Delete</a>
                           
                        </div>
                    </div> 
                    ';
                    })
                    ->make(true);
            }
            return view('discrepancyweight.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('discrepancyweight.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($request->all(), [
            'vehicle_type' => 'required',
            'factor' => 'required',
        ]);
        $falidate = true;
        if ($validator->fails()) {
            $falidate = false;
            $output = [
                'success' => false,
                'msg' => "It appears you have forgotten to complete something 33",
            ];
        }
        if ($falidate) {
            if (request()->ajax()) {
                try {
                    $data['created_by']=Auth()->User()->id;
                    $data = DiscrepancyWeight::create($data);
                    $output = [
                        'success' => true,
                        'msg' => "Weight Created  Successfully"
                    ];
                } catch (\Exception $e) {
                    \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                    $output = [
                        'success' => false,
                        'msg' => $e->getMessage(),
                    ];
                }
            }
        }
        return $output;
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
        $discrepancyweight=DiscrepancyWeight::find($id);
       
        try {
            return view('discrepancyweight.edit', compact('discrepancyweight'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

       
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
        $data = $request->except('_token');
        $validator = Validator::make($request->all(), [
            'vehicle_type' => 'required',
            'factor' => 'required',
        ]);
        $falidate = true;
        if ($validator->fails()) {
            $falidate = false;
            $output = [
                'success' => false,
                'msg' => "It appears you have forgotten to complete something 33",
            ];
        }
        if ($falidate) {
            if (request()->ajax()) {
                try {
                    $data['updated_by']=Auth()->User()->id;
                    $result = DiscrepancyWeight::find($id);
                    $result->update($data);
                    $result->touch();
                    
                    $output = [
                        'success' => true,
                        'msg' => "Weight Updated  Successfully"
                    ];
                } catch (\Exception $e) {
                    \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                    $output = [
                        'success' => false,
                        'msg' => $e->getMessage(),
                    ];
                }
            }
        }
        return $output;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            try {
                $can_be_deleted = true;
                $error_msg = '';
                //Check if any routing has been done
                //do logic here
                $items = DiscrepancyWeight::where('id', $id)
                    ->first();
                if ($can_be_deleted) {
                    if (!empty($items)) {
                        DB::beginTransaction();
                        $items->delete();
                        DB::commit();
                    }
                    $output = [
                        'success' => true,
                        'msg' => "Weight Deleted Successfully"
                    ];
                } else {
                    $output = [
                        'success' => false,
                        'msg' => $error_msg
                    ];
                }
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                $output = [
                    'success' => false,
                    'msg' => "Something Went Wrong"
                ];
            }
            return $output;
        }
    }
}
