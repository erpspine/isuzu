<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\materialdistributionmodel\MaterialDistributionModel;
use App\Models\Pna\Part_Template;
use Illuminate\Http\Request;

class PnaController extends Controller
{
    public function load_data()
    {
        $actions = Part_Template::get();
        return response()->json(['msg' => null, 'data' => $actions, 'success' => true], 200);
    }
    public function load_pna_data_by_model($model_id)
    {
        $actions = Part_Template::where('material_distribution_model_id',$model_id)->get();
        return response()->json(['msg' => null, 'data' => $actions, 'success' => true], 200);
    }
    public function material_distribution_models()
    {
        $models = MaterialDistributionModel::get();
        return response()->json(['msg' => null, 'data' => $models, 'success' => true], 200);
    }


}
