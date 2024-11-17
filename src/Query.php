<?php

namespace Rougin\Datatables;

use Rougin\Datatables\Source\SourceInterface;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Query
{
    /**
     * @var \Rougin\Datatables\Request
     */
    protected $request;

    /**
     * @var \Rougin\Datatables\Source\SourceInterface
     */
    protected $source;

    /**
     * @param \Rougin\Datatables\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param \Rougin\Datatables\Table $table
     *
     * @return \Rougin\Datatables\Result
     */
    public function getResult(Table $table)
    {
        $this->source->setTable($table);

        $result = new Result;

        $items = $this->source->getItems();
        $result->setItems($items);

        $filter = $this->source->getFiltered();
        $result->setFiltered($filter);

        $draw = $this->request->getDraw();
        $result->setDraw($draw);

        $total = $this->source->getTotal();
        return $result->setTotal($total);
    }

    /**
     * @param \Rougin\Datatables\Source\SourceInterface $source
     *
     * @return self
     */
    public function setSource(SourceInterface $source)
    {
        $this->source = $source;

        return $this;
    }
}
