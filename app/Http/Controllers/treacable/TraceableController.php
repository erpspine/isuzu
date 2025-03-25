<?php

namespace App\Http\Controllers\treacable;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\queryanswer\Queryanswer;

class TraceableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {

            $queries = Queryanswer::with('vehicle')->where('vehicle_id', $vehicle_id)->where(function ($query) {
                $query->whereHas('queries', function ($subquery) {
                    $subquery->where('quiz_type', 'traceable');
                })->orWhereHas('querycategory', function ($subquery) {
                    $subquery->where('quiz_type', 'traceable');
                });
            })->get();


            // where('status',2)->get();

            // $units = vehicle_units::where('status',0)->get();

            return DataTables::of($queries)

                ->addColumn('action', function ($units) {
                    return '
                <a href="' . route('vehicleunits.edit', [$units->id]) . '"  style="line-height: 20px;" class="btn btn-outline-success btn-circle btn-sm"><i class="fas fa-pencil-alt"></i></a>
                <a href="' . route('vehicleunits.destroy', [$units->id]) . '" style="line-height: 20px;" class="btn btn-outline-danger btn-circle btn-sm delete-unit"><i class="fas fa-trash"></i></a>

                 ';
                })

                ->addColumn('v_type', function ($units) {


                    switch ($units->route) {
                        case '1':
                            return 'F-Series';
                            break;
                        case '2':
                            return 'N-Series';
                            break;
                        case '3':
                            return 'N-Series';
                            break;
                        case '4':
                            return 'LCV';
                            break;
                        case '5':
                            return 'LCV';
                            break;
                    }
                })


                ->addColumn('model', function ($units) {
                    return $units->model->model_name;
                })



                ->make(true);
        }


        return view('traceable.index');
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
}
