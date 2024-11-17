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
     * @var \Rougin\Datatables\Config
     */
    protected $config;

    /**
     * @var \Rougin\Datatables\Source\SourceInterface
     */
    protected $source;

    /**
     * @param \Rougin\Datatables\Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Rougin\Datatables\Table $table
     *
     * @return \Rougin\Datatables\Result
     */
    public function getResult(Table $table)
    {
        $result = new Result;

        $filter = $this->source->getFiltered();
        $result->setFiltered($filter);

        $draw = $this->config->getDraw();
        $result->setDraw($draw);

        $items = $this->source->getItems();
        $result->setItems($items);

        $total = $this->source->getTotal();
        return $result->setTotal($total);
    }

    /**
     * @param \Rougin\Datatables\Source\SourceInterface $source
     * @return self
     */
    public function setSource(SourceInterface $source)
    {
        $this->source = $source;

        return $this;
    }
}
