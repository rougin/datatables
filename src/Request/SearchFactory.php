<?php

namespace Rougin\Datatables\Request;

class SearchFactory implements SearchCreation
{
    protected $regex = false;

    protected $value;

    public function make()
    {
        return new Search($this->value, $this->regex);
    }

    public function regex($regex)
    {
        $this->regex = $regex;

        return $this;
    }

    public function value($value)
    {
        if ($value === '')
        {
            $value = null;
        }

        $this->value = $value;

        return $this;
    }

    public static function http(array $data)
    {
        $self = new SearchFactory;

        $self->regex($data['regex'] === 'true');

        $self->value($data['value']);

        return $self->make();
    }
}
