<?php

namespace Rougin\Datatables\Request;

interface SearchCreation
{
    public function make();

    public function regex($regex);

    public function value($value);
}
