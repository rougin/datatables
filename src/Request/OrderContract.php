<?php

namespace Rougin\Datatables\Request;

interface OrderContract
{
    public function ascending();

    public function column();

    public function descending();
}
