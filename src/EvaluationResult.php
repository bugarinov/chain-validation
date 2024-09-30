<?php
namespace Bugarinov\ChainValidation;

/**
 * A class for handles reults of evaluation after AbstractLink::evaluate() is called
 * 
 * @package  Bugarinov\ChainValidation
 * @author   Yuliy Bugarin <bugarindev@yahoo.com>
 * @version  0.2.0
 * @access   public
 */
abstract class EvaluationResult
{
    /**
     * @var ?array
     */
    private $evaluatedData;

    /**
     * @var bool
     */
    private $hasError;

    /**
     * @var int
     */
    private $errorCode;

    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @var ?array
     */
    private $errorBody;

    public function __construct(?array $evaluatedData, string $errorMessage = null, int $errorCode = 0, ?array $errorBody = null)
    {
        $this->evaluatedData = $evaluatedData;
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
        $this->errorBody = $errorBody;

        $this->hasError = $this->errorCode != 0 || $this->errorMessage !== null;
    }

    public function hasError(): bool
    {
        return $this->hasError;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    public function getErrorBody(): ?array
    {
        return $this->errorBody;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getEvaluatedData(): ?array
    {
        return $this->evaluatedData;
    }
}