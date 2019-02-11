<?php

namespace Rougin\Datatables\Request;

class Search implements SearchContract
{
    protected $regex = false;

    protected $value;

    public function __construct($value, $regex = false)
    {
        $this->regex = $regex;

        $this->value = $value;
    }

    public function regex()
    {
        return $this->regex;
    }

    public function value()
    {
        return $this->value;
    }
}
