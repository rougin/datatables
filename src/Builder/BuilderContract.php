<?php

namespace Rougin\Datatables\Builder;

use Rougin\Datatables\Message\ResponseCreation;
use Rougin\Datatables\Message\RequestContract;

interface BuilderContract
{
    public function build(RequestContract $request);

    public function factory(ResponseCreation $factory);
}
