<?php

namespace App\Http\Controllers\gcachecksheet;

use App\Http\Controllers\Controller;
use App\Models\gcaauditcategory\GcaAuditReportCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppHelper;
use App\Models\gcaqueryitems\GcaQueryItem;
use App\Models\gcaquery\GcaQuery;
use App\Models\gcaqueryitemtag\GcaQueryItemTag;
use DataTables;
use DB;

class GcaChecksheetController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (request()->ajax()) {
      $categories = GcaQuery::get();
      return DataTables::of($categories)
        ->addColumn('action', function ($categories) {
          return '
               <a href="' . route('gca-checksheet.show', [$categories->id]) . '"  style="line-height: 20px;" class="btn btn-outline-primary btn-circle btn-sm"><i class=" fas fa-eye"></i></a>
               <a href="' . route('gca-checksheet.edit', [$categories->id]) . '"  style="line-height: 20px;" class="btn btn-outline-success btn-circle btn-sm"><i class="fas fa-pencil-alt"></i></a>
               <a href="' . route('gca-checksheet.destroy', [$categories->id]) . '" style="line-height: 20px;" class="btn btn-outline-danger btn-circle btn-sm delete_brand_button delete-query"><i class="fas fa-trash"></i></a>
                ';
        })
        ->addColumn('query_codes', function ($categories) {
          return '
               <a href="' . route('qcos-checksheet-list', [$categories->id]) . '" class="btn btn-xs btn-warning edit_brand_button">' . $categories->query_code . '</a>
              ';
        })
        ->addColumn('done_by', function ($categories) {
          $doneby = '';
          if ($categories->user_id > 0) {
            $doneby = $categories->user->name;
          }
          return  $doneby;
        })
        ->addColumn('has_quality', function ($categories) {
          $has_quality = 'No';
          if ($categories->has_quality ==1) {
            $has_quality = 'Yes';
          }
          return  $has_quality;
        })
        ->addColumn('has_description', function ($categories) {
          $has_description = 'No';
          if ($categories->has_description ==1) {
            $has_description = 'Yes';
          }
          return  $has_description;
        })
        ->addColumn('has_size', function ($categories) {
          $has_size = 'No';
          if ($categories->has_size ==1) {
            $has_size = 'Yes';
          }
          return  $has_size;
        })
        ->addColumn('user_updated', function ($categories) {
          $doneby = '';
          if ($categories->updated_by > 0) {
            $doneby = $categories->user_updated->name;
          }
          return  $doneby;
        })
        ->addColumn('last_update', function ($categories) {
          return  dateTimeFormat($categories->updated_at);
        })
        ->addColumn('image', function ($categories) {
          $url = asset('upload/' . $categories->icon);
          return '<img src="' . $url . '" border="0" width="40" class="img-rounded" align="center" />';
        })
        ->addColumn('vehicle_type', function ($categories) {
          $vtype = 'Light Commercial';
          if ($categories->vehicle_type == 2) {
            $vtype = 'Heavy Commercial';
          }
          return $vtype;
        })->rawColumns(['action', 'query_codes'])
        ->make(true);
    }
    return view('gcachecksheet.index');
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $gcacat = GcaAuditReportCategory::pluck('name', 'id');
    if ($request->input('zone_type')) {
      $data = $request->all();
      return view('gcachecksheet.create')->with(compact('gcacat', 'data'));
    }
    return view('gcachecksheet.create')->with(compact('gcacat'));
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
   
        $data = $request->only(['has_size', 'has_description', 'has_quality', 'zone_type', 'category_name', 'vehicle_type', 'gca_audit_report_category_id']);
        $data['user_id'] = auth()->user()->id;
        DB::beginTransaction();
        $gca_result = GcaQuery::create($data);
        if ($request->input('zone_type') == 'ABCD') {
          $tagsarray = [];
          foreach ($request->input('defects') as $key => $val) {
            $query_itemdata = array(
              'gca_query_id' => $gca_result->id,
              'defect' => $val,
              'query_name' => $val,
              'size' => $request->input('size')[$key],
              'description' => $request->input('description')[$key],
              'quantity' => $request->input('quantity')[$key],
              'zonea' => $request->input('zonea')[$key],
              'zoneb' => $request->input('zoneb')[$key],
              'zonec' => $request->input('zonec')[$key],
              'zoned' => $request->input('zoned')[$key],
            );
            $result = GcaQueryItem::create($query_itemdata);
            if (isset($request->input('tags')[$key]) > 0) {
              $tags = $request->input('tags')[$key];
              foreach ($tags as  $key => $val2) {
                $tagsarray[] = array(
                  'gca_query_id' => $gca_result->id,
                  'gca_query_item_id' => $result->id,
                  'name' => $val2,
                  'created_at'=>date('Y-m-d H:i:s'),
                  'updated_at'=>date('Y-m-d H:i:s'),
                );
              }
            }
          }
        } elseif ($request->input('zone_type') == 'Exterior-Interior') {
          $tagsarray = [];
          foreach ($request->input('defects') as $key => $val) {
            $query_itemdata = array(
              'gca_query_id' => $gca_result->id,
              'defect' => $val,
              'query_name' => $val,
              'size' => $request->input('size')[$key],
              'description' => $request->input('description')[$key],
              'quantity' => $request->input('quantity')[$key],
              'exterior' => $request->input('exterior')[$key],
              'interiorprimary' => $request->input('interiorprimary')[$key],
              'interiorsecondary' => $request->input('interiorsecondary')[$key]
            );
            $result = GcaQueryItem::create($query_itemdata);
            if (isset($request->input('tags')[$key]) > 0) {
              $tags = $request->input('tags')[$key];
              foreach ($tags as  $key => $val2) {
                $tagsarray[] = array(
                  'gca_query_id' => $gca_result->id,
                  'gca_query_item_id' => $result->id,
                  'name' => $val2,
                  'created_at'=>date('Y-m-d H:i:s'),
                  'updated_at'=>date('Y-m-d H:i:s'),
                );
              }
            }
          }
        } elseif ($request->input('zone_type') == 'No-Zones') {
          $tagsarray = [];
          foreach ($request->input('defects') as $key => $val) {
            $query_itemdata = array(
              'gca_query_id' => $gca_result->id,
              'defect' => $val,
              'query_name' => $val,
              'size' => $request->input('size')[$key],
              'description' => $request->input('description')[$key],
              'quantity' => $request->input('quantity')[$key],
              'weightfactor' => $request->input('weightfactor')[$key],
            );
            $result = GcaQueryItem::create($query_itemdata);
            if (isset($request->input('tags')[$key]) > 0) {
              $tags = $request->input('tags')[$key];
              foreach ($tags as  $key => $val2) {
                $tagsarray[] = array(
                  'gca_query_id' => $gca_result->id,
                  'gca_query_item_id' => $result->id,
                  'name' => $val2,
                  'created_at'=>date('Y-m-d H:i:s'),
                  'updated_at'=>date('Y-m-d H:i:s'),
                );
              }
            }
          }
        } elseif ($request->input('zone_type') == 'Fluid-Level') {
          $tagsarray = [];
          foreach ($request->input('defects') as $key => $val) {
            $query_itemdata = array(
              'gca_query_id' => $gca_result->id,
              'defect' => $val,
              'query_name' => $val,
              'size' => $request->input('size')[$key],
              'description' => $request->input('description')[$key],
              'quantity' => $request->input('quantity')[$key],
              'tenmmabove' => $request->input('tenmmabove')[$key],
              'fivemmabove' => $request->input('fivemmabove')[$key],
              'belowmin' => $request->input('belowmin')[$key],
              'notvisible' => $request->input('notvisible')[$key],
              'anyleak' => $request->input('anyleak')[$key],
              'incorrectfluid' => $request->input('incorrectfluid')[$key],
            );
            $result = GcaQueryItem::create($query_itemdata);
            if (isset($request->input('tags')[$key]) > 0) {
              $tags = $request->input('tags')[$key];
              foreach ($tags as  $key => $val2) {
                $tagsarray[] = array(
                  'gca_query_id' => $gca_result->id,
                  'gca_query_item_id' => $result->id,
                  'name' => $val2,
                  'created_at'=>date('Y-m-d H:i:s'),
                  'updated_at'=>date('Y-m-d H:i:s'),
                );
              }
            }
          }
        }elseif ($request->input('zone_type') == 'Noise') {
          $tagsarray = [];
          foreach ($request->input('defects') as $key => $val) {
            $query_itemdata = array(
              'gca_query_id' => $gca_result->id,
              'defect' => $val,
              'query_name' => $val,
              'size' => $request->input('size')[$key],
              'description' => $request->input('description')[$key],
              'quantity' => $request->input('quantity')[$key],
              'slight' => $request->input('slight')[$key],
              'moderate' => $request->input('moderate')[$key],
              'loud' => $request->input('loud')[$key]
            );
            $result = GcaQueryItem::create($query_itemdata);
            if (isset($request->input('tags')[$key]) > 0) {
              $tags = $request->input('tags')[$key];
              foreach ($tags as  $key => $val2) {
                $tagsarray[] = array(
                  'gca_query_id' => $gca_result->id,
                  'gca_query_item_id' => $result->id,
                  'name' => $val2,
                  'created_at'=>date('Y-m-d H:i:s'),
                  'updated_at'=>date('Y-m-d H:i:s'),
                );
              }
            }
          }
        }elseif ($request->input('zone_type') == 'Safety') {
          $tagsarray = [];
          foreach ($request->input('defects') as $key => $val) {
            $query_itemdata = array(
              'gca_query_id' => $gca_result->id,
              'defect' => $val,
              'query_name' => $val,
              'size' => $request->input('size')[$key],
              'description' => $request->input('description')[$key],
              'quantity' => $request->input('quantity')[$key],
              'L' => $request->input('L')[$key],
              'D' => $request->input('D')[$key],
              'W' => $request->input('W')[$key],
              'M' => $request->input('M')[$key],
              'F' => $request->input('F')[$key]
            );
            $result = GcaQueryItem::create($query_itemdata);
            if (isset($request->input('tags')[$key]) > 0) {
              $tags = $request->input('tags')[$key];
              foreach ($tags as  $key => $val2) {
                $tagsarray[] = array(
                  'gca_query_id' => $gca_result->id,
                  'gca_query_item_id' => $result->id,
                  'name' => $val2,
                  'created_at'=>date('Y-m-d H:i:s'),
                  'updated_at'=>date('Y-m-d H:i:s'),
                );
              }
            }
          }
        }
        if (count($tagsarray) > 0) {
          $result = GcaQueryItemTag::insert($tagsarray);
        }
        DB::commit();
        $output = [
          'success' => true,
          'msg' => "Query  Created Successfully"
        ];
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
  public function prepareOptions($request, $record)
  {
    $options    = $request->answer;
    $list       = array();
    for ($index = 0; $index < count($request->answer); $index++) {
      $spl_char   = ['\t', '\n', '\b', '\c', '\r', '\'', '\\', '\$', '\"', "'"];
      $list[$index]['option_value']   = str_replace($spl_char, '', $options[$index]);
    }
    return json_encode($list);
  }
  public function prepareNumericAnswers($request, $record)
  {
    $lower_limit    = $request->lower_limit;
    $upper_limit  = $request->upper_limit;
    $list       = array();
    $spl_char   = ['\t', '\n', '\b', '\c', '\r', '\'', '\\', '\$', '\"', "'"];
    $list[]['min']   = str_replace($spl_char, '', $lower_limit);
    $list[]['max']   = str_replace($spl_char, '', $upper_limit);
    return json_encode($list);
  }
  public function additional_checksheet($id)
  {
    $gcacat = GcaAuditReportCategory::pluck('name', 'id');
    $routing_query = GcaQuery::find($id);
    $quizanswers = [];
    if ($routing_query->quiz_type == 'single' || $routing_query->quiz_type == 'multiple' || $routing_query->quiz_type == 'numeric' || $routing_query->quiz_type == 'others') {
      $quizanswers = json_decode($routing_query->answers, true);
    }
    $totalcorrectanswers = [];
    if ($routing_query->quiz_type == 'multiple' || $routing_query->quiz_type == 'others') {
      $totalcorrectanswers = json_decode($routing_query->correct_answers, true);
    }
    return view('gcachecksheet.add')->with(compact('routing_query', 'gcacat', 'quizanswers', 'totalcorrectanswers'));
  }
  public function qca_additional_query(Request $request)
  {
    $itemcheck = true;
    $data = $request->only(['vehicle_type', 'gca_audit_report_category_id', 'category_name', 'quiz_type', 'query_code', 'status']);
    $data['user_id'] = auth()->user()->id;
    $item_data['query']  = $request->only(['can_sign', 'query_name', 'additional_field']);
    $validator = Validator::make($request->all(), [
      'vehicle_type' => 'bail|required|max:20',
      'gca_audit_report_category_id' => 'bail|required|max:20',
      'category_name' => 'bail|required|max:20',
      'query_name' => 'required',
      'quiz_type' => 'required',
      'query_code' => 'required',
    ]);
    $data['icon'] = 'default.jpg';
    if ($request->icon && $request->icon != "undefined") {
      $data['icon'] = (new AppHelper)->saveImage($request);
    }
    if ($request->quiz_type == 'single') {
      $data['answers'] = null;
      $data['total_options']      = null;
      $data['correct_answers'] = null;
      $data['total_correct_answer'] = 0;
    }
    if ($request->quiz_type == 'multiple') {
      $data['answers'] = $this->prepareOptions($request, $data);
      $data['total_options']      = $request->input('total_options');
      $data['total_correct_answers'] = $request->input('total_correct_answers');
      $data['correct_answers']      = $this->prepareMultiAnswers($request);
      $validator = Validator::make($request->all(), [
        'answer' => 'required',
        'correct_answers' => 'bail|required|max:5',
        'total_options' => 'bail|required|max:5',
        'total_correct_answers' => 'bail|required|max:5',
      ]);
    }
    if ($request->quiz_type == 'numeric') {
      $data['answers'] = 0;
      $data['answers'] = 0;
      $data['total_correct_answers'] = 0;
      $data['total_options']      = $request->input('total_options');
      $data['correct_answers']    = $request->input('correct_answers');
      $validator = Validator::make($request->all(), [
        'correct_answers' => 'required',
        'total_options' => 'bail|required|max:5',
      ]);
      if ($request->input('total_options') == 6 || $request->input('total_options') == 7) {
        $validator = Validator::make($request->all(), [
          'lower_limit' => 'required',
          'upper_limit' => 'required',
        ]);
        $data['answers'] = $this->prepareNumericAnswers($request, $data);
      }
    }
    // Check validation failure
    if ($validator->fails()) {
      $output = [
        'success' => false,
        'msg' => "It appears you have forgotten to complete something",
      ];
    }
    if (empty($request->input('query_name'))) {
      $itemcheck = false;
    }
    if (!$itemcheck) {
      $output = [
        'success' => false,
        'msg' => "You must add atleast one Query",
      ];
    }
    // Check validation success
    if ($validator->passes() && $itemcheck == true) {
      if (request()->ajax()) {
        try {
          $pos = GcaQuery::max('position');
          $data['position'] = $pos + 1;
          $result = GcaQuery::create($data);
          if ($result->id) {
            $queries = array();
            $i = 0;
            foreach ($item_data['query']['query_name'] as $key => $value) {
              $queries[] = array(
                'gca_query_id' => $result->id,
                'can_sign' => strip_tags($item_data['query']['can_sign'][$key]),
                'query_name' => strip_tags($item_data['query']['query_name'][$key]),
                'additional_field' => strip_tags($item_data['query']['additional_field'][$key]),
                'position' => $i,
              );
              $i++;
            }
            GcaQueryItem::insert($queries);
          }
          $output = [
            'success' => true,
            'msg' => "Query Created Successfully"
          ];
        } catch (\Exception $e) {
          \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
          $output = [
            'success' => false,
            'msg' => $e->getMessage(),
          ];
        }
        // return $output;
      }
    }
    return $output;
  }
  public function qcos_checksheet_list($id)
  {
    $querycategory = GcaQuery::find($id);
    return view('gcachecksheet.list')->with(compact('id', 'querycategory'));
  }
  public function qcos_listing(Request $request)
  {
    if (request()->ajax()) {
      $id = $request->quiz_id;
      $categories = GcaQueryItem::where('gca_query_id', $id)->get();
      return DataTables::of($categories)
        ->addColumn('action', function ($categories) {
          return '
                  <button data-href="' . route('change-qcos-answer', [$categories->id]) . '" title="Change" style="line-height: 20px;"  class="btn btn-outline-warning btn-circle btn-sm  edit_unit_button"><i class=" fas fa-edit"></i> </button>
                  <button data-href="' . route('edit-qcos-answer', [$categories->id]) . '" title="Edit"  style="line-height: 20px;"  class="btn btn-outline-success  btn-circle btn-sm edit_unit_button"><i class="fas fa-pencil-alt"></i></button>
                  <a href="' . route('deletechecksheetoption', [$categories->id]) . '" style="line-height: 20px;" class="btn btn-outline-danger btn-circle btn-sm delete-query"><i class="fas fa-trash"></i></a>';
        })
        ->addColumn('query_name', function ($categories) {
          return '
              <button data-href="' . route('gca-checksheet-answer-list', [$categories->id]) . '"  class="btn text-primary edit_unit_button">' . $categories->query_name . ' </button>
               ';
        })
        ->addColumn('image', function ($categories) {
          $url = asset('upload/' . $categories->icon);
          return '<img src="' . $url . '" border="0" width="40" class="img-rounded" align="center" />';
        })->rawColumns(['action', 'query_name'])
        ->make(true);
    }
  }
  public function change_qcos_answer($id)
  {
    if (request()->ajax()) {
      return view('gcachecksheet.changeanswer')->with(compact('id'));
    }
  }
  public function saveasave_gca_change_answernswer(Request $request)
  {
    $modelcheck = true;
    $itemcheck = true;
    $data = $request->only(['quiz_type']);
    $validator = Validator::make($request->all(), [
      'quiz_type' => 'required',
    ]);
    if ($request->quiz_type == 'single') {
      $data['answers'] = null;
      $data['total_options']      = null;
      $data['correct_answers'] = null;
      $data['total_correct_answer'] = 0;
    }
    if ($request->quiz_type == 'multiple' || $request->quiz_type == 'others') {
      $data['answers'] = $this->prepareOptions($request, $data);
      $data['total_options']      = $request->input('total_options');
      $data['total_correct_answers'] = ''; //$request->input('total_correct_answers');
      $data['correct_answers']      = ''; //$this->prepareMultiAnswers($request);
      $validator = Validator::make($request->all(), [
        'answer' => 'required',
        //'correct_answers' => 'bail|required|max:5',
        'total_options' => 'bail|required|max:5',
        //'total_correct_answers' => 'bail|required|max:5',
      ]);
    }
    if ($request->quiz_type == 'numeric') {
      $data['answers'] = 0;
      $data['answers'] = 0;
      $data['total_correct_answers'] = 0;
      $data['total_options']      = $request->input('total_options');
      $data['correct_answers']    = $request->input('correct_answers');
      $validator = Validator::make($request->all(), [
        'correct_answers' => 'required',
        'total_options' => 'bail|required|max:5',
      ]);
      if ($request->input('total_options') == 6 || $request->input('total_options') == 7) {
        $validator = Validator::make($request->all(), [
          'lower_limit' => 'required',
          'upper_limit' => 'required',
        ]);
        $data['answers'] = $this->prepareNumericAnswers($request, $data);
      }
    }
    // Check validation failure
    if ($validator->fails()) {
      $output = [
        'success' => false,
        'msg' => "It appears you have forgotten to complete something",
      ];
    }
    // Check validation success
    if ($validator->passes()) {
      if (request()->ajax()) {
        try {
          $id = $request->input('quiz_id');
          $data['use_defferent_routing'] = "Yes";
          $result = GcaQueryItem::find($id);
          $result->update($data);
          $result->touch();
          $output = [
            'success' => true,
            'msg' => "Routing Query Answer Updated Successfully"
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
  public function gca_checksheet_answer_list($id)
  {
    if (request()->ajax()) {
      $categories = GcaQueryItem::find($id);
      $rounting_categories = GcaQuery::find($categories->gca_query_id);
      return view('gcachecksheet.viewanswer')->with(compact('id', 'categories', 'rounting_categories'));
    }
  }
  public function edit_qcos_answer($id)
  {
    if (request()->ajax()) {
      $data =  GcaQueryItem::find($id);
      return view('gcachecksheet.editrouting')->with(compact('id', 'data'));
    }
  }
  public function update_checksheet_option(Request $request)
  {
    
    if (request()->ajax()) {
      try {
        $id = $request->input('quiz_id');
        $data = $request->only(['query_name', 'can_sign', 'additional_field']);
        $result = GcaQueryItem::find($id);
        $result->update($data);
        $result->touch();
        $output = [
          'success' => true,
          'msg' => "Routing Query Answer Updated Successfully"
        ];
      } catch (\Exception $e) {
        \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        $output = [
          'success' => false,
          'msg' => $e->getMessage(),
        ];
      }
    }
    return $output;
  }
  public function deletechecksheetoption($id)
  {
    if (request()->ajax()) {
      try {
        DB::beginTransaction();
        //Delete Query  details
        GcaQueryItem::find($id)
          ->delete();
        DB::commit();
        $output = [
          'success' => true,
          'msg' => "Query Deleted Successfully"
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
    $zones = GcaQuery::find($id);
    if (request()->ajax()) {
     
      $categories = GcaQueryItem::where('gca_query_id',$id)->get();
      return DataTables::of($categories)
        ->addColumn('action', function ($categories) {
          return '
               <a href="#"  style="line-height: 20px;" class="btn btn-outline-success btn-circle btn-sm"><i class="fas fa-pencil-alt"></i></a>
               <a href="#" style="line-height: 20px;" class="btn btn-outline-danger btn-circle btn-sm delete_brand_button delete-query"><i class="fas fa-trash"></i></a>
                ';
        })->rawColumns(['action', 'query_codes'])
        ->make(true);
    }

    return view('gcachecksheet.show',compact('zones'));
  }
  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $gcacat = GcaAuditReportCategory::pluck('name', 'id');
    $routing_query = GcaQuery::find($id);
    $quizanswers = [];
    if ($routing_query->quiz_type == 'single' || $routing_query->quiz_type == 'multiple' || $routing_query->quiz_type == 'numeric' || $routing_query->quiz_type == 'others') {
      $quizanswers = json_decode($routing_query->answers, true);
    }
    $totalcorrectanswers = [];
    if ($routing_query->quiz_type == 'multiple' || $routing_query->quiz_type == 'others') {
      $totalcorrectanswers = json_decode($routing_query->correct_answers, true);
    }
    return view('gcachecksheet.edit')->with(compact('routing_query', 'gcacat', 'quizanswers', 'totalcorrectanswers'));
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
    $data = $request->only(['vehicle_type', 'gca_audit_report_category_id', 'category_name', 'quiz_type', 'query_code', 'status']);
    $data['updated_by'] = auth()->user()->id;
    $validator = Validator::make($request->all(), [
      'vehicle_type' => 'bail|required|max:20',
      'gca_audit_report_category_id' => 'bail|required|max:20',
      'category_name' => 'bail|required|max:20',
      'quiz_type' => 'required',
      'query_code' => 'required',
    ]);
    if ($request->icon && $request->icon != "undefined") {
      $data['icon'] = (new AppHelper)->saveImage($request);
    }
    if ($request->quiz_type == 'single') {
      $data['answers'] = null;
      $data['total_options']      = null;
      $data['correct_answers'] = null;
      $data['total_correct_answer'] = 0;
    }
    if ($request->quiz_type == 'multiple') {
      $data['answers'] = $this->prepareOptions($request, $data);
      $data['total_options']      = $request->input('total_options');
      $data['total_correct_answers'] = '';  //$request->input('total_correct_answers');
      $data['correct_answers']      = ''; //$this->prepareMultiAnswers($request);
      $validator = Validator::make($request->all(), [
        'answer' => 'required',
        'total_options' => 'bail|required|max:5',
      ]);
    }
    if ($request->quiz_type == 'numeric') {
      $data['answers'] = 0;
      $data['answers'] = 0;
      $data['total_correct_answers'] = 0;
      $data['total_options']      = $request->input('total_options');
      $data['correct_answers']    = $request->input('correct_answers');
      $validator = Validator::make($request->all(), [
        'correct_answers' => 'required',
        'total_options' => 'bail|required|max:5',
      ]);
      if ($request->input('total_options') == 6 || $request->input('total_options') == 7) {
        $validator = Validator::make($request->all(), [
          'lower_limit' => 'required',
          'upper_limit' => 'required',
        ]);
        $data['answers'] = $this->prepareNumericAnswers($request, $data);
      }
    }
    // Check validation failure
    if ($validator->fails()) {
      $output = [
        'success' => false,
        'msg' => "It appears you have forgotten to complete something",
      ];
    }
    // Check validation success
    if ($validator->passes()) {
      if (request()->ajax()) {
        try {
          $result = GcaQuery::find($id);
          $result->update($data);
          $result->touch();
          $output = [
            'success' => true,
            'msg' => "Query Created Successfully"
          ];
        } catch (\Exception $e) {
          \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
          $output = [
            'success' => false,
            'msg' => $e->getMessage(),
          ];
        }
        // return $output;
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
        $items = GcaQuery::where('id', $id)
          ->first();
        if ($can_be_deleted) {
          if (!empty($items)) {
            DB::beginTransaction();
            //Delete Query  details
            GcaQueryItem::where('gca_query_id', $id)
              ->delete();
            $items->delete();
            DB::commit();
          }
          $output = [
            'success' => true,
            'msg' => "Query Deleted Successfully"
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
