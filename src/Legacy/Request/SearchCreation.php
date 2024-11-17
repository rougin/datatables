<?php

namespace Rougin\Datatables\Legacy\Request;

interface SearchCreation
{
    public function make();

    public function regex($regex);

    public function value($value);
}
