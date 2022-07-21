<?php
namespace Bugarinov\ChainValidation\Tests\Classes;

use Bugarinov\ChainValidation\AbstractLink;
use Bugarinov\ChainValidation\EvaluationResult;

class LinkSuccess extends AbstractLink
{
    public function evaluate(?array $data): EvaluationResult
    {
        /**
         * Do some data validations here.
         * You can alter the data depending on your condition.
         * Links are primarily used for complex validations but
         * can also be used to alter/mutate data depending on
         * the requirement. This will be handling the
         * business logic of the app.
         * 
         * Return an object of EvaluationResult. When there is no error
         * just create an EvaluationResult with the $data as the argument.
         */

        return new EvaluationResult($data);
    }
}