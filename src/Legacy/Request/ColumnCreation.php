<?php

namespace Rougin\Datatables\Legacy\Request;

interface ColumnCreation
{
    public function data($data);

    public function make();

    public function name($name);

    public function orderable($orderable);

    public function search($search);

    public function searchable($searchable);
}
