<?php
namespace Bugarinov\ChainValidation\Tests;

use Bugarinov\ChainValidation\ChainValidation;
use Bugarinov\ChainValidation\Tests\Classes\LinkErrorCode;
use PHPUnit\Framework\TestCase;

class ErrorCodeTest extends TestCase
{
    public function testErrorCode()
    {
        $chain = new ChainValidation();
        $chain->add(new LinkErrorCode());
        $chain->add(new LinkErrorCode());
        $chain->add(new LinkErrorCode());
        $chain->add(new LinkErrorCode());
        $chain->add(new LinkErrorCode());
        $chain->add(new LinkErrorCode());
        $chain->add(new LinkErrorCode());
        $chain->add(new LinkErrorCode());
        $chain->add(new LinkErrorCode());
        $chain->add(new LinkErrorCode());
        $chain->execute([]);

        $this->assertEquals(true, $chain->hasError());
        $this->assertEquals('ERROR WITH CODE!', $chain->getErrorMessage());
        $this->assertEquals(401, $chain->getErrorCode());
    }
}