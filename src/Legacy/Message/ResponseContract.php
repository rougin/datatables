<?php

namespace Rougin\Datatables\Legacy\Message;

interface ResponseContract
{
    public function data();

    public function draw();

    public function error();

    public function filtered();

    public function result();

    public function total();
}
