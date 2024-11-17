<?php

namespace Rougin\Datatables\Legacy\Builder;

use Rougin\Datatables\Legacy\Message\ResponseCreation;
use Rougin\Datatables\Legacy\Message\RequestContract;

interface BuilderContract
{
    public function build(RequestContract $request);

    public function factory(ResponseCreation $factory);
}
