<?php


namespace Witooh\GridDataprovider;

use Illuminate\Support\Collection;
use Input;

class JqGrid extends Grid
{

    protected $page;

    protected function requestAdaptor()
    {
        $this->take = (int)Input::get('rows', 10);
        $this->page = (int)Input::get('page', 1);
        $this->setSkip($this->take, $this->page);
        $this->condition = array();
        $this->sort = array(
            array(Input::get('sidx'), Input::get('sord')),
        );
    }

    public function toGridData()
    {
        $data = array();

        foreach ($this->data as $index => $value) {
            $data[] = array('id' => $value['id'], 'cell' => $value);
        }

        $totalPage  = ceil($this->total / $this->take);
        $this->page = $this->page > $this->total ? $this->total : $this->page;

        return array(
            'page'    => $this->page,
            'total'   => (int)$totalPage,
            'records' => $this->total,
            'rows'    => $data,
        );
    }

    protected function setSkip($take, $page)
    {
        $this->skip = $take * $page - $take;
    }
}