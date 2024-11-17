<?php

namespace Rougin\Datatables\Legacy\Request;

interface OrderContract
{
    public function ascending();

    public function column();

    public function descending();
}
