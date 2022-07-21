<?php
namespace Bugarinov\ChainValidation\Tests\Classes;

use Bugarinov\ChainValidation\AbstractLink;
use Bugarinov\ChainValidation\EvaluationResult;
use Bugarinov\ChainValidation\ResultSuccess;

class LinkSuccess extends AbstractLink
{
    public function evaluate(?array $data): EvaluationResult
    {
        /**
         * Do some data validations here.
         * You can alter the data depending on your condition.
         * Links are primarily used for complex validations but
         * can also be used to alter/mutate data depending on
         * your requirement. This will be handling parts of the
         * business logic of your app.
         */



         /**
         * When there is no error just create a ResultSuccess 
         * object with the $data as the argument.
         */

        return new ResultSuccess($data);
    }
}