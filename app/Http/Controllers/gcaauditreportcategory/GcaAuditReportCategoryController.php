<?php

namespace App\Http\Controllers\gcaauditreportcategory;

use App\Http\Controllers\Controller;
use App\Models\gcaauditcategory\GcaAuditReportCategory;
use App\Models\gcaquerycategorycv\GcaQueryCategoryCv;
use App\Models\gcaquerycategoryitemcv\GcaQueryCategoryItemCv;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GcaAuditReportCategoryController extends Controller
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
                $category = GcaAuditReportCategory::get();
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
                           
                            <a class="dropdown-item" href="' . route('gca-audit-report-category.edit', [$category->id]) . '"><i
                                    class="ti-pencil-alt"></i> Edit</a>
                            <a class="dropdown-item delete_brand_button delete-category" href="' . route('gca-audit-report-category.destroy', [$category->id]) . '"><i
                                    class="ti-trash"></i> Delete</a>
                           
                        </div>
                    </div> 
                    ';
                    })
                    ->make(true);
            }
            return view('gcaauditcategory.index');
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
 

return view('gcaauditcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'short_form' => 'bail|required',
            'name' => 'bail|required',
          
        ]);
        // Check validation failure
        if ($validator->fails()) {
            $output = [
                'success' => false,
                'msg' => "It appears you have forgotten to complete something",
            ];
        }
        $data = $request->except(['_token']);
   
        $data['user_id']=auth()->user()->id;
        // Check validation success
        if ($validator->passes()) {
            if (request()->ajax()) {
                try {
                    $data = GcaAuditReportCategory::create($data);
                    $output = [
                        'success' => true,
                        'msg' => "Category Created Successfully"
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
    public function edit(GcaAuditReportCategory $gcaAuditReportCategory)
    {
     
        try {
          
            return view('gcaauditcategory.edit', compact('gcaAuditReportCategory'));
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
            'short_form' => 'bail|required',
            'name' => 'bail|required',
          
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
                  
                    $data['user_id']=auth()->user()->id;
                    $result = GcaAuditReportCategory::find($id);
                    $result->update($data);
                    $result->touch();
                    $output = [
                        'success' => true,
                        'msg' => "Category  Updated Successfully"
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
                $exists=GcaQueryCategoryCv::where('gca_audit_report_category_id',$id)->exists();
                if($exists){
                    $output = ['success' => false,
                                 'msg' => "Record already used!!"
                             ];
                 $can_be_deleted = false;
 
                }

               
                if ($can_be_deleted) {
                   $items = GcaAuditReportCategory::where('id', $id)
                    ->first();
                    if (!empty($items)) {
                        DB::beginTransaction();
                        $items->delete();
                        DB::commit();
                    }
                    $output = [
                        'success' => true,
                        'msg' => "Category Deleted Successfully"
                    ];
                } 
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                $output = [
                    'success' => false,
                    'msg' =>$e->getMessage()
                ];
            }
            return $output;
        }
    }
}
