<?php

namespace Rougin\Datatables;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Search
{
    /**
     * @var boolean
     */
    protected $regex = false;

    /**
     * @var string|null
     */
    protected $value = null;

    /**
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return boolean
     */
    public function isRegex()
    {
        return $this->regex;
    }

    /**
     * @param boolean $regex
     *
     * @return self
     */
    public function setRegex($regex)
    {
        $this->regex = $regex;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
