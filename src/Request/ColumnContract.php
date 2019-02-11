<?php

namespace Rougin\Datatables\Request;

interface ColumnContract
{
    public function data();

    public function name();

    public function orderable();

    public function search();

    public function searchable();
}
