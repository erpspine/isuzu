<?php

namespace App\Http\Controllers\gcadefectaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\gcaqueryanswer\GcaQueryAnswer;
use Carbon\Carbon;
use App\Models\shop\Shop;
use App\Models\gcaauditcategory\GcaAuditReportCategory;
use Illuminate\Support\Facades\Validator;
use DB;

class GcaDefectActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $status = request()->get('status', null);
            $vehicle_type = request()->get('vehicle_type', null);
            $daterange = request()->get('daterange', null);
            $shop_id = request()->get('shop_id', null);
            $gca_audit_report_category_id = request()->get('gca_audit_report_category_id', null);


            $categories = GcaQueryAnswer::with(['vehicle' =>function($query){
                $query->where('gca_audit_complete', '1');
                

            }])->whereHas('vehicle', function ($query)  {
               
                $query->where('gca_audit_complete', '1');
              });

              if (!empty($vehicle_type)) {
             
                $categories->where('vehicle_type', $vehicle_type);
            }

            if (!empty($shop_id)) {
             
                $categories->where('shop_id', $shop_id);
            }

            if (!empty($status)) {

                $stus="No";
                if($status=='CLOSED'){
                    $stus="Yes";

                }
             
                $categories->where('is_corrected', $stus);
            }

            if (!empty($gca_audit_report_category_id)) {
             
                $categories->where('gca_audit_report_category_id', $gca_audit_report_category_id);
            }

            if (!empty($daterange)) {
                $datearr = explode('-', $daterange);
                $datefrom = Carbon::createFromFormat('d/m/Y', $datearr[0])->format('Y-m-d');
                $dateto = Carbon::createFromFormat('d/m/Y', $datearr[1])->format('Y-m-d');
               // [gca_completion_date]

               

                 $categories->whereHas('vehicle', function ($query) use ($datefrom,$dateto)  {
               
                    $query->whereBetween('gca_completion_date', [$datefrom, $dateto]);
                  });
                  
                  
                  
             }


              $categories->get();
              
              
              
           
            return DataTables::of($categories)
                ->addColumn('chasis', function ($categories) {
                    return  $categories->vehicle->vin_no;
                })
             
                ->addColumn('lotjob', function ($categories) {
                    return  $categories->vehicle->lot_no . ', ' . $categories->vehicle->job_no;
                })
                ->addColumn('categoryname', function ($categories) {
                    return  $categories->auditCategory->name;
                })
                ->addColumn('shops', function ($categories) {
                    return  $categories->shop->report_name;
                })
                ->addColumn('defect', function ($categories) {
                    return  $categories->defect . ' ' . $categories->defect_tag;
                })
                ->addColumn('status', function ($categories) {
                    $status='Open';
                    if($categories->is_corrected=='Yes'){
                        $status='Closed';

                    }
                    return  $status;
                })
                ->addColumn('date', function ($categories) {
                    return  dateFormat($categories->vehicle->gca_completion_date);
                })->addColumn('image', function ($categories) {
                    if($categories->defect_image !=null){
                        return '
                        <img src="'.$categories->DefectImageUri.'" class="img-fluid img-thumbnail" alt="Sheep">
                        ';
                    }else{
                        return '';
                    }
                   

                })->addColumn('action', function ($categories) {
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
                        <a class="dropdown-item" href="' . route('gcadefects-action.show', [$categories->id]) . '"><i
                                class="ti-eye"></i> Open</a>
                        <a class="dropdown-item" href="' . route('gcadefects-action.edit', [$categories->id]) . '"><i
                                class="ti-pencil-alt"></i> Edit</a>
                        <a class="dropdown-item delete_brand_button delete-gca" href="' . route('gcadefects-action.destroy', [$categories->id]) . '"><i
                                class="ti-trash"></i> Delete</a>
                    </div>
                </div> 
                ';
                })->rawColumns(['action','image'])
                ->make(true);
        }
        $shops = Shop::where('check_shop', 1)->get()->pluck('report_name', 'id');
        $category=GcaAuditReportCategory::get()->pluck('name', 'id');
        return view('gcadefectaction.index',compact('shops','category'));
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
        $details = GcaQueryAnswer::with(['vehicle' =>function($query){
            $query->where('gca_audit_complete', '1');
            

        }])->whereHas('vehicle', function ($query)  {
           
            $query->where('gca_audit_complete', '1');
          })->where('id',$id)->first();

          return view('gcadefectaction.show',compact('details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $gcaqueryanswer=GcaQueryAnswer::find($id);
            $shops = Shop::where('check_shop', 1)->get()->pluck('report_name', 'id');
           //dd($shops);
            $category=GcaAuditReportCategory::get()->pluck('name', 'id');
            return view('gcadefectaction.edit', compact('gcaqueryanswer', 'shops','category'));
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
        $validator = Validator::make($request->all(), [
            'shop_id' => 'bail|required',
            'gca_audit_report_category_id' => 'required',
            'defect_count' => 'required',
            'weight' => 'bail|required',
            'defect' => 'required',
            'is_corrected' => 'required',
        ]);
        // Check validation failure
        if ($validator->fails()) {
            $output = [
                'success' => false,
                'msg' => "It appears you have forgotten to complete something",
            ];
        }
        $data = $request->except(['_token']);
        if ($validator->passes()) {
            if (request()->ajax()) {
                try {
                    $data['updated_by'] = auth()->user()->id;
                    $result = GcaQueryAnswer::find($id);
                    $result->update($data);
                    $result->touch();
                    $output = [
                        'success' => true,
                        'msg' => "Gca Updated Updated Successfully"
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
                $items = GcaQueryAnswer::where('id', $id)
                    ->first();
                if ($can_be_deleted) {
                    if (!empty($items)) {
                        DB::beginTransaction();
                        //Delete Query  details
                        $items->delete();
                        DB::commit();
                    }
                    $output = [
                        'success' => true,
                        'msg' => "Gca Record Deleted Successfully"
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
