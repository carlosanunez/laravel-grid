<?php


namespace Witooh\GridDataprovider;

use Illuminate\Support\Collection;

class JqGrid extends Grid
{

    protected $page;

    protected function createCriteria()
    {
        $this->page = $this->input->get('page');
        $this->take = $this->input->get('rows');
        $this->setSkip($this->take, $this->page);

        return array(
            'page'      => $this->page,
            'skip'      => $this->skip,
            'take'      => $this->take,
            'condition' => array(),
            'sort'      => array(
                array($this->input->get('sidx'), $this->input->get('sord')),
            ),
        );
    }

    public function getData()
    {
        $data = array();

        foreach ($this->data as $index => $data) {
            $data[] = array('id' => $data['id'], 'cell' => $data);
        }

        $totalPage  = ceil($this->total / $this->take);
        $this->page = $this->page > $this->total ? $this->total : $this->page;

        return array(
            'page'    => $this->page,
            'total'   => $totalPage,
            'records' => $this->total,
            'rows'    => $data,
        );
    }

    public function setSkip($take, $page)
    {
        $this->skip = $take * $page - $take;
    }
}