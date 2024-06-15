<?php

namespace App\Http\Controllers\gcalcvchecksheet;


use App\Http\Controllers\Controller;
use App\Models\gcaauditcategory\GcaAuditReportCategory;
use App\Models\gcaquerycategoryitemcv\GcaQueryCategoryItemCv;
use App\Models\gcaquerytitle\GcaQueryTitle;
use App\Models\gcasteps\GcaSteps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use DB;
use Log;

class GcaLcvCheckSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if (request()->ajax()) {
            $titles = GcaQueryTitle::where('vehicle_type','LCV')->get();
            return DataTables::of($titles)
            ->addColumn('action', function ($titles) {
                return '
                     <a href="' . route('gcalcvchecksheet.show', [$titles->id]) . '"  style="line-height: 20px;" class="btn btn-outline-primary btn-circle btn-sm"><i class=" fas fa-eye"></i></a>
                     <a href="' . route('gcalcvchecksheet.edit', [$titles->id]) . '"  style="line-height: 20px;" class="btn btn-outline-success btn-circle btn-sm"><i class="fas fa-pencil-alt"></i></a>
                     <a href="' . route('gcalcvchecksheet.destroy', [$titles->id]) . '" style="line-height: 20px;" class="btn btn-outline-danger btn-circle btn-sm delete_brand_button delete-query"><i class="fas fa-trash"></i></a>
                      ';
              })
              ->addColumn('step', function ($titles) {
                return  $titles->gcaSteps->title;
              })->rawColumns(['action', 'query_codes'])
              ->make(true);
          }
          return view('gcachecksheetlcv.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->input('query_category')) {
            $steps = GcaSteps::pluck('title', 'id');
            $data = $request->all();
            return view('gcachecksheetlcv.create')->with(compact('steps', 'data'));
        }
       
        return view('gcachecksheetlcv.create');
        //->with(compact('gcacat'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (request()->ajax()) {
            try {
                $input = $request->except(['_token']);
                $validator = Validator::make($request->all(), [
                    'query_group_name' => 'bail|required',
                    'title' => 'bail|required',
                    'gca_stage_id' => 'bail|required',
                ]);
                // Check validation failure
                $noerrors = true;
                if ($validator->fails()) {
                    $output = [
                        'success' => false,
                        'msg' => "Make sure you capture all required fields",
                    ];
                    $noerrors = false;
                }
                if (empty($input['quality_item'])) {
                    $output = [
                        'success' => false,
                        'msg' => "Make sure capture category",
                    ];
                    $noerrors = false;
                }
                if ($noerrors) {
                    DB::beginTransaction();
                  // $input['vehicle_type'] = 'CV';
                    $input['vehicle_type'] = 'LCV';
                    $result = GcaQueryTitle::create($input);
                    $data = [];
                    foreach ($request->input('quality_item') as $key => $val) {
                        $data[] = array(
                            'name' => $val,
                            'gca_audit_report_category_id' => $input['gca_audit_report_category_id'][$key],
                            'position' => $input['position'][$key]
                        );
                    }
                    $result->querycategories()->createMany($data);
                    DB::commit();
                    $output = [
                        'success' => true,
                        'msg' => "Query Category Successfully"
                    ];
                }
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                $output = [
                    'success' => false,
                    'msg' => $e->getMessage(),
                ];
            }
            return $output;
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $title=GcaQueryTitle::find($id);
     
        if (request()->ajax()) {
            $records=GcaQueryCategoryItemCv::with(['queryCategory.titles'=>function($q) use($id){
                $q->where('id', $id);
            }])->whereHas('queryCategory.titles', function ($query) use ($id) {
                $query->where('id', $id);
            })->get();
            return DataTables::of($records)
            ->addColumn('category', function ($records) {
                return  $records->queryCategory->name;
              })
              ->addColumn('title', function ($records) {
                return  $records->queryCategory->titles->query_group_name;
              })->rawColumns(['action', 'query_codes'])
              ->make(true);
          }
          return view('gcachecksheetlcv.show',compact('title'));
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
    public function load_cv_category(Request $request)
    {
        $term = $request->term; // Search term from Select2
        $data = GcaAuditReportCategory::get(['id', 'name']); // Adjust columns as needed
        return response()->json($data);
    }
}
