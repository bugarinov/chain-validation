<?php
namespace Bugarinov\ChainValidation\Tests\Classes;

use Bugarinov\ChainValidation\AbstractLink;
use Bugarinov\ChainValidation\EvaluationResult;
use Bugarinov\ChainValidation\ResultFailed;
use Bugarinov\ChainValidation\ResultSuccess;

class MockedLink extends AbstractLink
{
    public function evaluate(?array $data): EvaluationResult
    {
        $a = rand(0, 99);
        $b = rand(0, 99);

        if ($a != $b) {
            return new ResultFailed('not match!', 400);
        }

        return new ResultSuccess($data);
    }
}