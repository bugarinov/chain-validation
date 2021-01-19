<?php
namespace Bugarinov\ChainValidation\Tests;

use Bugarinov\ChainValidation\ChainValidation;
use PHPUnit\Framework\TestCase;

class ChainValidationTest extends TestCase
{
    public function testValid()
    {
        $chain = new ChainValidation();
        $chain->add(new LinkSuccess());
        $chain->execute([]);

        $this->assertEquals(false, $chain->hasError());
    }

    public function testInvalid()
    {
        $chain = new ChainValidation();
        $chain->add(new LinkFail());
        $chain->execute([]);

        $this->assertEquals(true, $chain->hasError());
    }

    public function testData()
    {
        $chain = new ChainValidation();

        $chain->add(new LinkCounting());
        $chain->add(new LinkCounting());
        $chain->add(new LinkCounting());
        $chain->add(new LinkCounting());
        $chain->add(new LinkCounting());

        $validatedData = $chain->execute([]);

        $this->assertEquals(false, $chain->hasError());
        $this->assertEquals([0,1,2,3,4], $validatedData);
    }

    public function testErrorData()
    {
        $chain = new ChainValidation();

        $chain->add(new LinkCountingHalt());
        $chain->add(new LinkCountingHalt());
        $chain->add(new LinkCountingHalt());
        $chain->add(new LinkCountingHalt());
        $chain->add(new LinkCountingHalt());
        $chain->add(new LinkCountingHalt());
        $chain->add(new LinkCountingHalt());
        $chain->add(new LinkCountingHalt());
        $chain->add(new LinkCountingHalt());
        $chain->add(new LinkCountingHalt());

        $validatedData = $chain->execute([]);
        $this->assertEquals(null, $validatedData);
        $this->assertEquals(true, $chain->hasError());
        $this->assertEquals('LIMIT REACHED!', $chain->getErrorMessage());
    }
}