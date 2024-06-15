<?php

namespace App\Http\Controllers\materialdistribution;

use App\Http\Controllers\Controller;
use App\Models\materialdistributionmodel\MaterialDistributionModel;
use App\Models\Pna\Part_Template;
use App\Models\unit_model\Unit_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use DataTables;

use Illuminate\Support\Facades\Validator;

class MaterialDistributionController extends Controller
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
               $materialDistribution = Part_Template::whereNotNull('id');
               $material_distribution_model_id = request()->get('material_distribution_model_id', null);
               if (!empty($material_distribution_model_id)) {
                   $materialDistribution->where('material_distribution_model_id', $material_distribution_model_id);
               }
               $materialDistribution-> get();
                return DataTables::of($materialDistribution)
                ->addColumn('model', function ($materialDistribution) {
                    return @$materialDistribution->model->name;
                })
                    ->addColumn('action', function ($materialDistribution) {
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
                            <a class="dropdown-item" href="' . route('material-distribution.show', [$materialDistribution->id]) . '"><i
                                    class="ti-eye"></i> Open</a>
                            <a class="dropdown-item" href="' . route('material-distribution.edit', [$materialDistribution->id]) . '"><i
                                    class="ti-pencil-alt"></i> Edit</a>

                        </div>
                    </div>
                    ';
                    })
                    ->make(true);
            }
            $models = MaterialDistributionModel::pluck('name', 'id');
            return view('material_list.index',compact('models'));
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
        $models = MaterialDistributionModel::pluck('name', 'id');
        $template='mdl';
        return view('material_list.create',compact('models','template'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //Set maximum php execution time
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', -1);
            if ($request->hasFile('part_upload')) {
                $file = $request->file('part_upload');
                $parsed_array = Excel::toArray([], $file);
                $imported_data = array_splice($parsed_array[0], 1);
                $formated_data = [];
                $is_valid = true;
                $error_msg = '';
                $total_rows = count($imported_data);
                DB::beginTransaction();
                foreach ($imported_data as $key => $value) {
                    if (count($value) < 32) {
                        $is_valid =  false;
                        $error_msg = "Some of the columns are missing. Please, use latest CSV file template.";
                        break;
                    }
                   // dd($is_valid);
                    $row_no = $key + 1;
                    $part_array = [];
                   // $part_array['created_by'] = Auth()->User()->id;
                    $part_array['created_at'] = date('Y-m-d H:i:s');
                    $part_array['updated_at'] = date('Y-m-d H:i:s');
                    $part_array['material_distribution_model_id']= $request->material_distribution_model_id;
                    //Add Part Number
                    //Batch Number number
                    // $batch_number = trim($value[19]);
                    // if (!empty($batch_number)) {
                    //     $check_part_exist = PackagingList::where('batch_number', $batch_number)->exists();
                    //     if ($check_part_exist) {
                    //         $is_valid =  false;
                    //         $error_msg = "This Part  Number is in use check  row no. $row_no";
                    //         break;
                    //     } else {
                    //         $part_array['batch_number'] = $batch_number;
                    //     }
                    //     $part_array['batch_number'] = $batch_number;
                    // } else {
                    //     $is_valid =  false;
                    //     $error_msg = "Batch   Number  is required in row no. $row_no";
                    //     break;
                    // }
                    //Add other name
                    // $pna_case = trim($value[0]);
                    // if (!empty($pna_case)) {
                    //     $part_array['pna_case'] = $pna_case;
                    // } else {
                    //     $is_valid =  false;
                    //     $error_msg = "Case Number is required in row no. $row_no";
                    //     break;
                    // }
                    // //Slock
                    // $Box = trim($value[1]);
                    // if (!empty($Box)) {
                    //     $part_array['Box'] = $Box;
                    // } else {
                    //     $is_valid =  false;
                    //     $error_msg = "Box Number is required in row no. $row_no";
                    //     break;
                    // }
                    //Part Number
                    $partnumber = trim($value[2]);
                    if (!empty($partnumber)) {
                        $part_array['partnumber'] = $partnumber;
                    } else {
                        $is_valid =  false;
                        $error_msg = "Part Number is required in row no. $row_no";
                        break;
                    }
                    //Description
                    $Description = trim($value[3]);
                    if (!empty($Description)) {
                        $part_array['Description'] = $Description;
                    } else {
                        $is_valid =  false;
                        $error_msg = "Description  No is required in row no. $row_no";
                        break;
                    }
                    //upc
                    $upc = trim($value[4]);
                    if (!empty($upc)) {
                        $part_array['upc'] = $upc;
                    } else {
                        $is_valid =  false;
                        $error_msg = "Upc  is required in row no. $row_no";
                        break;
                    }

                    //FNA
                    // $FNA = trim($value[5]);
                    // if (!empty($FNA)) {
                    //     $part_array['FNA'] = $FNA;
                    // } else {
                    //     $is_valid =  false;
                    //     $error_msg = "FNA is required in row no. $row_no";
                    //     break;
                    // }
                    //Qty
                    $qty_lot = trim($value[6]);
                    if (!empty($qty_lot)) {
                        $part_array['qty_lot'] = $qty_lot;
                    } else {
                        $is_valid =  false;
                        $error_msg = "Qty is required in row no. $row_no";
                        break;
                    }
                    $part_array = [
                        'created_at' => now(),
                        'updated_at' => now(),
                        'partnumber' => trim($value[2]), // Ensure partnumber is trimmed
                        'Description' => trim($value[3]),
                        'upc' => trim($value[4]),
                        'qty_lot' => trim($value[6]),
                        'pna_case' => isset($value[0]) ? $value[0] : null,
                        'Box' => isset($value[1]) ? $value[1] : null,
                        'FNA' => isset($value[5]) ? $value[5] : null,
                        'LOC1' => isset($value[7]) ? $value[7] : null,
                        'QTY1' => isset($value[8]) ? $value[8] : null,
                        'LOC2' => isset($value[9]) ? $value[9] : null,
                        'QTY2' => isset($value[10]) ? $value[10] : null,
                        'LOC3' => isset($value[11]) ? $value[11] : null,
                        'QTY3' => isset($value[12]) ? $value[12] : null,
                        'LOC4' => isset($value[13]) ? $value[13] : null,
                        'QTY4' => isset($value[14]) ? $value[14] : null,
                        'LOC5' => isset($value[15]) ? $value[15] : null,
                        'QTY5' => isset($value[16]) ? $value[16] : null,
                        'LOC6' => isset($value[17]) ? $value[17] : null,
                        'QTY6' => isset($value[18]) ? $value[18] : null,
                        'LOC7' => isset($value[19]) ? $value[19] : null,
                        'QTY7' => isset($value[20]) ? $value[20] : null,
                        'LOC8' => isset($value[21]) ? $value[21] : null,
                        'QTY8' => isset($value[22]) ? $value[22] : null,
                        'LOC9' => isset($value[23]) ? $value[23] : null,
                        'QTY9' => isset($value[24]) ? $value[24] : null,
                        'LOC10' => isset($value[25]) ? $value[25] : null,
                        'QTY10' => isset($value[26]) ? $value[26] : null,
                        'LOC11' => isset($value[27]) ? $value[27] : null,
                        'QTY11' => isset($value[28]) ? $value[28] : null,
                        'LOC12' => isset($value[29]) ? $value[29] : null,
                        'QTY12' => isset($value[30]) ? $value[30] : null,
                    ];

                    //Assign to formated array
                    $formated_data[] = $part_array;
                }
            }
            if (!$is_valid) {
                throw new \Exception($error_msg);
            }
  // Commit transaction before processing chunks
  DB::commit();

          // Chunk size calculation
        $chunk_size = floor(2100 / count($formated_data));

        // Begin new transaction for inserting/updating chunks
        DB::beginTransaction();

        foreach (array_chunk($formated_data, $chunk_size) as $data_chunk) {
            foreach ($data_chunk as $data) {
                // Update or create records based on partnumber
                Part_Template::updateOrCreate(['partnumber' => $data['partnumber'],'material_distribution_model_id'=>$request->material_distribution_model_id], $data);
            }
        }

        // Commit the transaction
        DB::commit();
        $output = [
            'success' => 1,
            'msg' => 'Packaging List Imported Successfully!!'
        ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => 0,
                'msg' => $e->getMessage()
            ];
            return redirect('material-distribution/create')->with('notification', $output);
        }
        return redirect('material-distribution/create')->with('status', $output);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $details=Part_Template::find($id);

        return view('material_list.show',compact('details'));
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
            $details=Part_Template::find($id);
            $models = MaterialDistributionModel::pluck('name', 'id');
            return view('material_list.edit', compact('details','models'));
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
            'partnumber' => 'bail|required',
            'Description' => 'required',

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


                    $result = Part_Template::find($id);
                    $result->update($data);
                    $result->touch();
                    $output = [
                        'success' => true,
                        'msg' => "Record Updated Successfully"
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
        //
    }
}
