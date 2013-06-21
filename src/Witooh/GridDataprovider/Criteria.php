<?php

namespace Witooh\GridDataprovider;
use DB;
use Illuminate\Database\Query\Builder;

class Criteria {

    /**
     * @var Builder
     */
    public $query;

    public function __construct($table){
        $this->query = DB::table($table);
    }

    public function compare($column, $value, $like=true){
        if(!empty($value)){
            if($like){
                $value = '%'.$value.'%';
                $operator = 'LIKE';
            }else{
                $operator = '=';
            }
            $this->query->where($column, $operator, $value);
        }
    }

    public function orCompare($column, $value, $like=true){
        if(!empty($value)){
            if($like){
                $value = '%'.$value.'%';
                $operator = 'LIKE';
            }else{
                $operator = '=';
            }
            $this->query->orWhere($column, $operator, $value);
        }
    }
}