<?php

namespace App\Http\Controllers\gcafollowup;

use App\Http\Controllers\Controller;
use App\Models\gcafollowup\GcaFollowup;
use App\Models\gcascore\GcaScore;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GcaFollowUpController extends Controller
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
                $gca = GcaFollowup::get();
                return DataTables::of($gca)
                    ->addColumn('action', function ($gca) {
                        return '
                       <a href="' . route('closegca', [$gca->id]) . '" title="Close"  class="btn btn-xs btn-success close-gca"><i class="mdi mdi-tooltip-edit"></i> Close </a>
                           &nbsp;
                        <a href="' . route('gcafollowup.edit', [$gca->id]) . '" class="btn btn-xs btn-primary edit_brand_button"><i class="glyphicon glyphicon-edit"></i>Edit</a>
                           &nbsp;
                          <a href="' . route('gcafollowup.destroy', [$gca->id]) . '" class="btn btn-xs btn-danger delete_brand_button delete-gca"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                    ';
                    })
                    ->make(true);
            }
            return view('gcafollowup.index');
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
        try {
            return view('gcafollowup.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
                    'note' => 'required',
                ]);
                $data = $request->except(['_token']);
                if ($validator->fails()) {
                    $output = [
                        'success' => false,
                        'msg' => "It appears you have forgotten to complete something",
                    ];
                }
                $data['created_by'] = auth()->user()->id;
                $data['status'] = 'Active';
                GcaFollowup::create($data);
                DB::commit();
                $output = [
                    'success' => true,
                    'msg' => "Follow Up Created Successfully"
                ];
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
        $gca = GcaFollowup::find($id);
        return view('gcafollowup.edit')->with(compact('gca'));
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
            'note' => 'bail|required',
        ]);
        // Check validation failure
        if ($validator->fails()) {
            $output = [
                'success' => false,
                'msg' => "It appears you have forgotten to complete something",
            ];
        }
        $data = $request->only('note');
        if ($validator->passes()) {
            if (request()->ajax()) {
                try {
                    $result = GcaFollowup::find($id);
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
        if (request()->ajax()) {
            try {
                $can_be_deleted = true;
                $error_msg = '';
                //Check if any routing has been done
                //do logic here
                $items = GcaFollowup::where('id', $id)
                    ->first();
                if ($can_be_deleted) {
                    if (!empty($items)) {
                        DB::beginTransaction();
                        $items->delete();
                        DB::commit();
                    }
                    $output = [
                        'success' => true,
                        'msg' => "Record Deleted Successfully"
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
    public function closegca($id)
    {
        if (request()->ajax()) {
            try {
                DB::beginTransaction();
                $record = GcaFollowup::find($id);
                $record->status = 'Closed';
                $record->save();
                DB::commit();
                $output = [
                    'success' => true,
                    'msg' => "Follow Up Closed"
                ];
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
