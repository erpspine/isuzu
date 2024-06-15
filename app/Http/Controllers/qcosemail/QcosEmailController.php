<?php

namespace App\Http\Controllers\qcosemail;

use App\Http\Controllers\Controller;
use App\Models\appuser\Appuser;
use App\Models\qcosemail\QcosEmail;
use App\Models\user\User;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QcosEmailController extends Controller
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
                $email = QcosEmail::get();
                return DataTables::of($email)
                    
                    ->addColumn('action', function ($email) {
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
                            <a class="dropdown-item" href="' . route('qcosemail.edit', [$email->id]) . '"><i
                                    class="ti-pencil-alt"></i> Edit</a>
                            <a class="dropdown-item delete_brand_button delete-email" href="' . route('qcosemail.destroy', [$email->id]) . '"><i
                                    class="ti-trash"></i> Delete</a>
                           
                        </div>
                    </div> 
                    ';
                    })
                    ->make(true);
            }
            return view('qcosemail.index');
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
          
            return view('qcosemail.create');
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
        $validator = Validator::make($request->all(), [
            'email' => 'email|bail|required|unique:qcos_emails,email',
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
   
        $data['created_by']=auth()->user()->id;
        // Check validation success
        if ($validator->passes()) {
            if (request()->ajax()) {
                try {
                    $data = QcosEmail::create($data);
                    $output = [
                        'success' => true,
                        'msg' => "Email Created Successfully"
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
    public function edit(QcosEmail $qcosemail)
    {
        try {
           
            $source=$qcosemail->source;
            if($source=='System Users'){
                $users = User::get()->pluck('name','id');

            }else{
                $users = Appuser::get()->pluck('name','id');
            }

            return view('qcosemail.edit', compact('qcosemail','users'));
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
            'email' => 'email|bail|required',
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
                  
                    $data['created_by']=auth()->user()->id;
                    $result = QcosEmail::find($id);
                    $result->update($data);
                    $result->touch();
                    $output = [
                        'success' => true,
                        'msg' => "Email  Updated Successfully"
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
                $items = QcosEmail::where('id', $id)
                    ->first();
                if ($can_be_deleted) {
                    if (!empty($items)) {
                        DB::beginTransaction();
                        $items->delete();
                        DB::commit();
                    }
                    $output = [
                        'success' => true,
                        'msg' => "Email Deleted Successfully"
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

    public function select_user(Request $request)
    {
        $q = $request->search;
        $source = $request->source;

        if($source=='System Users'){
            $branches = User::where('name', 'LIKE', '%'.$q.'%')
            ->limit(6)->get();

        }else if($source=='App Users'){
            $branches = Appuser::where('name', 'LIKE', '%'.$q.'%')
            ->limit(6)->get();

        }

        
            
        return response()->json($branches);
    }

    public function search_user_details(Request $request)
    {
      $user_id = $request->user_id;
       $source = $request->source;


        if($source=='System Users'){
            $record = User::find($user_id );
    

        }else if($source=='App Users'){
            $record = Appuser::find($user_id );

        }

            
        return response()->json(['master' => $record]);
    } 

}
