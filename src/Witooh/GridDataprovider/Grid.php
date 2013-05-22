<?php


namespace Witooh\GridDataprovider;

use Illuminate\Support\Collection;

abstract class Grid {

    /**
     * @var IGridRepository
     */
    protected $repository;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $input;

    protected $data;
    protected $total;

    protected $criteria;

    protected $condition;
    protected $skip;
    protected $take;
    protected $sort;

    public function createInstance(){
        return clone $this;
    }

    /**
     * @param IGridRepository $repo
     * @param array $req
     * @return Grid
     */
    public function make(IGridRepository $repo, array $req){
        $dataProvider = $this->createInstance();
        $dataProvider->repository = $repo;
        $dataProvider->input = new Collection($req);
        $dataProvider->criteria = $this->createCriteria();
        $dataProvider->fetchTotal();
        $dataProvider->fetchData();

        return $dataProvider;
    }

    protected function fetchTotal(){
        $this->total = $this->repository->findGridCount($this->criteria);
    }

    protected function fetchData(){
        $this->data = $this->repository->findGridData($this->criteria);
    }

    /**
     * @return array
     */
    abstract protected function createCriteria();

    /**
     * @return array
     */
    abstract public function getData();
}