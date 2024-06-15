<?php

namespace App\Http\Controllers\division;

use App\Http\Controllers\Controller;
use App\Models\plantdivision\PlantDivision;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {

            $division = PlantDivision::get();

       return DataTables::of($division)

          ->addColumn('action', function ($division) {
               return '
                    <a href="#" class="btn btn-xs btn-primary edit_brand_button"><i class="glyphicon glyphicon-edit"></i>Edit</a>
                       &nbsp;
                      <a href="#" class="btn btn-xs btn-danger delete_brand_button delete-user"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                ';
           })



   

    ->make(true);
      

   }


       return view('division.index');
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
        $validator = Validator::make($request->all(), [
            'division_name' => 'bail|required'  
        ]);




   $data = $request->only(['division_name']);
   $data['status'] = 1;

  
    if ($validator->passes()) {

         if (request()->ajax()) {
            try {
                      
             $data = PlantDivision::create($data);    

                $output = ['success' => true,
                            'msg' => "Division Created Successfully"
                        ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                    
                $output = ['success' => false,
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
