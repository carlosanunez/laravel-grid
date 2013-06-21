<?php


namespace Witooh\GridDataprovider;

use Illuminate\Support\Collection;
use App;
use Input;
use DB;

abstract class Grid
{
    protected $data;
    protected $total;

    /**
     * @var Criteria
     */
    protected $criteria;

    protected $condition;
    protected $skip;
    protected $take;
    protected $sort;
    protected $primaryKey;

    protected function createInstance()
    {
        return clone $this;
    }

    /**
     * @param Criteria $criteria
     * @param string $primaryKey
     * @return Grid
     */
    public function make(Criteria $criteria, $primaryKey = 'id')
    {
        $dataProvider = $this->createInstance();
        $dataProvider->primaryKey = $primaryKey;
        $dataProvider->requestAdaptor();
        $dataProvider->criteria = $criteria;
        $dataProvider->setPagination();
        $dataProvider->setOrder();

        return $dataProvider;
    }

    protected function setOrder()
    {
        foreach ($this->sort as $sort) {
            if (!empty($sort[0])) {
                $this->criteria->query->orderBy($sort[0], $sort[1]);
            }
        }
    }

    protected function setPagination()
    {
        $this->criteria->query->skip($this->skip);
        $this->criteria->query->take($this->take);
    }

    protected function queryData()
    {
        $column = $this->criteria->query->columns[0];

        if(empty($column)){
            $column = '*';
        }elseif($column != '*'){
            $this->criteria->query->columns[] = $this->primaryKey;
        }
        $this->criteria->query->columns[0] = DB::raw('SQL_CALC_FOUND_ROWS ' . $column);
        $this->data = $this->criteria->query->get();
    }

    protected function queryTotal()
    {
        $this->total = DB::select('SELECT FOUND_ROWS() as total')[0]['total'];
    }

    /**
     * @return array
     */
    public function getData()
    {
        $this->queryData();
        $this->queryTotal();

        return $this->toGridData();
    }

    /**
     * @return array
     */
    abstract protected function requestAdaptor();

    /**
     * @return array
     */
    abstract public function toGridData();
}