<?php
namespace Bugarinov\ChainValidation;

class ResultFailed extends EvaluationResult
{
    public function __construct(string $errorMessage, int $errorCode = 0)
    {
        parent::__construct(null, $errorMessage, $errorCode);
    }
}