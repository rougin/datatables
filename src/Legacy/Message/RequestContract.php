<?php

namespace Rougin\Datatables\Legacy\Message;

interface RequestContract
{
    public function columns();

    public function draw();

    public function length();

    public function orders();

    public function search();

    public function start();
}
