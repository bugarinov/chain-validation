<?php
namespace Bugarinov\ChainValidation\Tests\Classes;

use Bugarinov\ChainValidation\AbstractLink;
use Bugarinov\ChainValidation\EvaluationResult;
use Bugarinov\ChainValidation\ResultFailed;

class LinkErrorBody extends AbstractLink
{
    /** @var array */
    public const ERROR_BODY = [
        'foo' => 'body error test!'
    ];

    public function evaluate(?array $data): EvaluationResult
    {
        return new ResultFailed('ERROR WITH BODY!', 400, self::ERROR_BODY);
    }
}