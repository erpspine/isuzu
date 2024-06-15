<?php

namespace App\Http\Controllers\materialdistributionmodel;

use App\Http\Controllers\Controller;
use App\Models\materialdistributionmodel\MaterialDistributionModel;
use App\Models\unit_model\Unit_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Pna\Part_Template;

class MaterialDistributionModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $models = MaterialDistributionModel::whereNotNull('id');
            $material_distribution_model_id = request()->get('material_distribution_model_id', null);
            if (!empty($material_distribution_model_id)) {
                $models->where('material_distribution_model_id', $material_distribution_model_id);
            }

            $models-> get();
            return DataTables::of($models)
                ->addColumn('action', function ($models) {
                    return '
               <a href="' . route('material-distribution-model.edit', [$models->id]) . '"  style="line-height: 20px;" class="btn btn-outline-success btn-circle btn-sm"><i class="fas fa-pencil-alt"></i></a>
               <a href="' . route('material-distribution-model.destroy', [$models->id]) . '" style="line-height: 20px;" class="btn btn-outline-danger btn-circle btn-sm delete-model"><i class="fas fa-trash"></i></a>
                ';
                })
                ->addColumn('category', function ($models) {
                    return @$models->category->model_name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('materialdistributionmodels.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $models = Unit_model::pluck('model_name', 'id');
        return view('materialdistributionmodels.create')->with(compact('models'));
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
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                ]);
                if ($validator->fails()) {
                    $output = [
                        'success' => false,
                        'msg' => "It appears you have forgotten to complete something",
                    ];
                }
                $input = $request->except(['_token']);
                if ($validator->passes()) {
                    $model = MaterialDistributionModel::create($input);
                    $output = [
                        'success' => true,
                        'msg' => "Model Created Successfully"
                    ];
                }
            } catch (\Exception $e) {
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
        $models = Unit_model::pluck('model_name', 'id');
        $materialDistribution = MaterialDistributionModel::find($id);
        return view('materialdistributionmodels.edit')->with(compact('materialDistribution', 'models'));
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
        if (request()->ajax()) {
            try {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                ]);
                $input = $request->except(['_token']);
                if ($validator->fails()) {
                    $output = [
                        'success' => false,
                        'msg' => "It appears you have forgotten to complete something",
                    ];
                }
                if ($validator->passes()) {
                    $result = MaterialDistributionModel::find($id);
                    $result->update($input);
                    $result->touch();
                    $output = [
                        'success' => true,
                        'msg' => "Model Updated Successfully"
                    ];
                }
            } catch (\Exception $e) {
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
                $items = MaterialDistributionModel::where('id', $id)
                    ->first();
                $materials = Part_Template::where('material_distribution_model_id', $id)
                    ->get();
                if ($can_be_deleted) {
                    if (!empty($items)) {
                        DB::beginTransaction();
                        $materials->delete();
                        $items->delete();
                        DB::commit();
                    }
                    $output = [
                        'success' => true,
                        'msg' => "Model Deleted Successfully"
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
