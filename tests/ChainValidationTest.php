<?php
namespace Bugarinov\ChainValidation\Tests;

use Bugarinov\ChainValidation\ChainValidation;
use Bugarinov\ChainValidation\Tests\Classes\LinkCounting;
use Bugarinov\ChainValidation\Tests\Classes\LinkCountingHalt;
use Bugarinov\ChainValidation\Tests\Classes\LinkFail;
use Bugarinov\ChainValidation\Tests\Classes\LinkSuccess;
use PHPUnit\Framework\TestCase;

class ChainValidationTest extends TestCase
{
    
    /**
     * A simple test to check that the
     * chain execution returned valid results
     * 
     * @see LinkSuccess class for details
     */
    public function testValid()
    {
        $chain = new ChainValidation();
        $chain->add(new LinkSuccess());
        $chain->execute([]);

        $this->assertEquals(false, $chain->hasError());
    }

    /**
     * A simple test to check that the
     * chain execution returned invalid results
     * 
     * @see LinkFail class for details
     */
    public function testInvalid()
    {
        $chain = new ChainValidation();
        $chain->add(new LinkFail());
        $chain->execute([]);

        $this->assertEquals(true, $chain->hasError());
    }



    /**
     * A simple test that alters the data and
     * add the current number of items to the
     * array.
     * 
     * @see LinkCounting class for details
     */
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

    /**
     * A simple test that alters the data and
     * add the current number of items to the
     * array BUT there is a maximum limit
     * before the chain execution fails
     * 
     * @see LinkCountingHalt class for details
     */
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