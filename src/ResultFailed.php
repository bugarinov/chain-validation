<?php
namespace Bugarinov\ChainValidation;

class ResultFailed extends EvaluationResult
{
    public function __construct(string $errorMessage, int $errorCode = 0, ?array $errorBody = null)
    {
        parent::__construct(null, $errorMessage, $errorCode, $errorBody);
    }
}