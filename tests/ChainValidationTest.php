<?php
use Bugarinov\ChainValidation\ChainValidation;
use Bugarinov\ChainValidation\Tests\Classes\LinkCounting;
use Bugarinov\ChainValidation\Tests\Classes\LinkCountingHalt;
use Bugarinov\ChainValidation\Tests\Classes\LinkErrorBody;
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
        $payload = ['data'];

        $chain = new ChainValidation();
        $chain->add(new LinkSuccess());
        $validatedData = $chain->execute($payload);

        $this->assertEquals(false, $chain->hasError());
        $this->assertEquals(0, $chain->getErrorCode());
        $this->assertEquals(null, $chain->getErrorMessage());
        $this->assertEquals(null, $chain->getErrorBody());

        $this->assertEquals($payload, $validatedData);
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
        $validatedData = $chain->execute([]);

        $this->assertEquals(true, $chain->hasError());
        $this->assertEquals(400, $chain->getErrorCode());
        $this->assertEquals('error', $chain->getErrorMessage());
        $this->assertEquals(null, $chain->getErrorBody());

        $this->assertEquals(null, $validatedData);
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
        $this->assertEquals(0, $chain->getErrorCode());
        $this->assertEquals(null, $chain->getErrorMessage());
        $this->assertEquals(null, $chain->getErrorBody());

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

        $this->assertEquals(true, $chain->hasError());
        $this->assertEquals(400, $chain->getErrorCode());
        $this->assertEquals('LIMIT REACHED!', $chain->getErrorMessage());
        $this->assertEquals(null, $chain->getErrorBody());

        $this->assertEquals(null, $validatedData);
    }

    /**
     * A simple test that returns an error
     * with a body
     * 
     * @see LinkErrorBody class for details
     */
    public function testInvalidWithBodyResponse()
    {
        $chain = new ChainValidation();

        $chain->add(new LinkErrorBody());

        $validatedData = $chain->execute(['data']);

        $this->assertEquals(true, $chain->hasError());
        $this->assertEquals(400, $chain->getErrorCode());
        $this->assertEquals('ERROR WITH BODY!', $chain->getErrorMessage());
        $this->assertEquals(LinkErrorBody::ERROR_BODY, $chain->getErrorBody());

        $this->assertEquals(null, $validatedData);
    }
}