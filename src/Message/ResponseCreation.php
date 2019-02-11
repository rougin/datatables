<?php

namespace Rougin\Datatables\Message;

interface ResponseCreation
{
    public function data($data);

    public function draw($draw);

    public function error($error);

    public function filtered($filtered);

    public function make();

    public function total($total);
}
