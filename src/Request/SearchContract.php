<?php

namespace Rougin\Datatables\Request;

interface SearchContract
{
    public function regex();

    public function value();
}
