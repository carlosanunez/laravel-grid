<?php


namespace Witooh\GridDataprovider;

use Illuminate\Database\Query\Builder;

abstract class Grid
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $data;
    protected $total;

    /**
     * @var \Illuminate\Database\Query\Builder
     */
    protected $criteria;

    protected $skip;
    protected $take;
    protected $sort;
    protected $isFromData;

    public function __construct(){
        $this->requestAdaptor();
    }

    protected function createInstance()
    {
        return clone $this;
    }

    /**
     * @return int
     */
    public function getTake(){
        return $this->take;
    }

    /**
     * @return int
     */
    public function getSkip(){
        return $this->skip;
    }

    /**
     * @return array|null
     */
    public function getSort(){
        return $this->sort;
    }

    /**
     * @param \Illuminate\Database\Query\Builder $criteria
     * @return Grid
     */
    public function make($criteria){

        $this->criteria = $criteria;
        $this->setPagination();
        $this->setOrder();

        return $this->getData();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $data
     * @param $total
     * @return array
     */
    public function makeFromData($data, $total){
        $this->data = $data;
        $this->total = $total;
        return $this->toGridData();
    }

    protected function setOrder()
    {
        foreach ($this->sort as $sort) {
            if (!empty($sort[0])) {
                $this->criteria->orderBy($sort[0], $sort[1]);
            }
        }
    }

    protected function setPagination()
    {
        $this->criteria->skip($this->skip);
        $this->criteria->take($this->take);
    }

    protected function queryData()
    {
        $this->data = $this->criteria->get();
    }

    protected function queryTotal()
    {
//        $result = DB::select('SELECT FOUND_ROWS() as total');
//        $this->total = $result[0]['total'];
        $this->total = $this->criteria->count();
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