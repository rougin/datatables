<?php

namespace Rougin\Datatables;

use LegacyPHPUnit\TestCase as Legacy;

/**
 * @codeCoverageIgnore
 *
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Testcase extends Legacy
{
    /**
     * @param string $exception
     *
     * @return void
     */
    public function doSetExpectedException($exception)
    {
        if (method_exists($this, 'expectException'))
        {
            /** @phpstan-ignore-next-line */
            $this->expectException($exception);

            return;
        }

        /** @phpstan-ignore-next-line */
        $this->setExpectedException($exception);
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public function doExpectExceptionMessage($message)
    {
        if (! method_exists($this, 'expectExceptionMessage'))
        {
            $exception = 'Exception';

            /** @phpstan-ignore-next-line */
            $this->setExpectedException($exception, $message);

            return;
        }

        $this->expectExceptionMessage($message);
    }
}
