<?php
namespace Bugarinov\ChainValidation\Tests\Classes;

use Bugarinov\ChainValidation\AbstractLink;
use Bugarinov\ChainValidation\EvaluationResult;

class MockedLink extends AbstractLink
{
    public function evaluate(?array $data): EvaluationResult
    {
        return new EvaluationResult($data);
    }
}