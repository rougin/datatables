<?php

namespace Rougin\Datatables\Legacy\Request;

interface ColumnContract
{
    public function data();

    public function name();

    public function orderable();

    public function search();

    public function searchable();
}
