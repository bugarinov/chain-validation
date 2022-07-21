<?php
use Bugarinov\ChainValidation\ChainValidation;
use Bugarinov\ChainValidation\EvaluationResult;
use Bugarinov\ChainValidation\ResultFailed;
use Bugarinov\ChainValidation\ResultSuccess;
use Bugarinov\ChainValidation\Tests\Classes\MockedLink;
use PHPUnit\Framework\TestCase;

/**
 * Mocking links is useful when your Link relies on an external dependency i.e. API, database, files, etc..
 */
class WithMockingTest extends TestCase
{
    public function testError()
    {
        $payload = ['data payload'];
        
        // the evaluate function is the only function we need to mock
        $mock = $this->createPartialMock(MockedLink::class, ['evaluate']);

        // Create the chain
        $chain = new ChainValidation();
        $chain->add($mock);

        // Mock the evaluate function
        $mock->expects($this->once())
            ->method('evaluate')
            ->with($payload)
            ->willReturn(new ResultFailed('error', 400));

        // Execute the chain
        $result = $chain->execute($payload);

        $this->assertEquals(true, $chain->hasError());
        $this->assertEquals(400, $chain->getErrorCode());
        $this->assertEquals('error', $chain->getErrorMessage());

        $this->assertEquals(null, $result);
    }

    public function testOK()
    {
        $payload = ['data payload'];
        
        // the evaluate function is the only function we need to mock
        $mock = $this->createPartialMock(MockedLink::class, ['evaluate']);

        // Create the chain
        $chain = new ChainValidation();
        $chain->add($mock);

        // Mock the evaluate function
        $mock->expects($this->once())
            ->method('evaluate')
            ->with($payload)
            ->willReturn(new ResultSuccess($payload));

        // Execute the chain
        $result = $chain->execute($payload);

        $this->assertEquals(false, $chain->hasError());
        $this->assertEquals(0, $chain->getErrorCode());
        $this->assertEquals(null, $chain->getErrorMessage());

        $this->assertEquals($payload, $result);
    }

    public function testMultipleLink()
    {
        // the evaluate function is the only function we need to mock
        $mock1 = $this->createPartialMock(MockedLink::class, ['evaluate']);
        $mock2 = $this->createPartialMock(MockedLink::class, ['evaluate']);

        // Create the chain
        $chain = new ChainValidation();
        $chain->add($mock1);
        $chain->add($mock2);

        // Set expectations
        $mock1->expects($this->once())
            ->method('evaluate')
            ->willReturn(new ResultSuccess(['hello']));

        $mock2->expects($this->once())
            ->method('evaluate')
            ->with(['hello'])
            ->willReturn(new ResultSuccess(['hello', 'world']));

        // Execute the chain
        $result = $chain->execute([]);

        // Assert response
        $this->assertEquals(false, $chain->hasError());
        $this->assertEquals(0, $chain->getErrorCode());
        $this->assertEquals(null, $chain->getErrorMessage());

        // Assert payload result
        $this->assertEquals(['hello', 'world'], $result);
    }
}