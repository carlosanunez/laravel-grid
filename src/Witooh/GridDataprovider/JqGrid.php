<?php


namespace Witooh\GridDataprovider;

use Input;

class JqGrid extends Grid
{

    protected $page;

    protected function requestAdaptor()
    {
        $this->take = (int)Input::get('rows', 10) ?: 10;
        $this->page = (int)Input::get('page', 1) ?: 1;
        $this->setSkip($this->take, $this->page);
        if(Input::has('sidx')){
            $this->sort = array(
                Input::get('sidx'),
                Input::get('sord'),
            );
        }else{
            $this->sort = null;
        }
    }

    public function toGridData()
    {
        $data = array();

        /** @var $value \Illuminate\Database\Eloquent\Model */
        foreach ($this->data->getIterator() as $value) {
            $data[] = array('id' => $value->getKey(), 'cell' => $value->toArray());
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