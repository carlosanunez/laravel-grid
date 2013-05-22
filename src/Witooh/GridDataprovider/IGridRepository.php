<?php


namespace Witooh\GridDataprovider;


interface IGridRepository {
    public function findGridData($criteria);
    public function findGridCount($criteria);
}