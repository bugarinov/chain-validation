<?php
namespace Bugarinov\ChainValidation;

class ResultSuccess extends EvaluationResult
{
    public function __construct(?array $data)
    {
        parent::__construct($data);
    }
}