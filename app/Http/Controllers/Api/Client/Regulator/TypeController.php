<?php

namespace App\Http\Controllers\Api\Client\Regulator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;
use App\Models\Regulator\Tag\Type as RecordModel;


class TypeController extends Controller
{
    private $model = null ;
    private $fields = [ 'id','name','desp' , 'pid' , 'record_index' ] ;
    public function __construct(){
        $this->model = new RecordModel();
    }
    /**
     * Listing function
     */
    public function index(Request $request){
        // $perpage = 
        return response([
            'records' => $this->model->childNodes()->get(),
            'message' => 'អានព័ត៌មាននៃគណនីបានរួចរាល់ !' 
        ],200 );
    }
    /** Mini display */
    public function compact(Request $request)
    {
        /** Format from query string */
        $search = isset( $request->search ) && $request->serach !== "" ? $request->search : false ;
        $perPage = isset( $request->perPage ) && $request->perPage !== "" ? $request->perPage : 1000 ;
        $page = isset( $request->page ) && $request->page !== "" ? $request->page : 1 ;
        $queryString = [
            "where" => [
                // 'default' => [
                //     [
                //         'field' => 'model' ,
                //         'value' => ''
                //     ],
                // ],
                // 'in' => [] ,
                // 'not' => [
                //     [
                //         'field' => 'id' ,
                //         'value' => 4
                //     ]
                // ] ,
                // 'like' => [
                //     [
                //         'field' => 'number' ,
                //         'value' => $number === false ? "" : $number
                //     ],
                //     [
                //         'field' => 'year' ,
                //         'value' => $date === false ? "" : $date
                //     ]
                // ] ,
            ] ,
            "pagination" => [
                'perPage' => $perPage,
                'page' => $page
            ],
            "search" => $search === false ? [] : [
                'value' => $search ,
                'fields' => [
                    'name' , 'desp'
                ]
            ],
            "order" => [
                'field' => 'record_index' ,
                'by' => 'asc'
            ],
        ];
        $request->merge( $queryString );
        $crud = new CrudController(new RecordModel(), $request, $this->fields );
        $responseData = $crud->pagination(true, $this->model->childNodes()->orderby('record_index','asc') );
        $responseData['message'] = __("crud.read.success");
        $responseData['ok'] = true ;
        return response()->json($responseData);
    }

}
