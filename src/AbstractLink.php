<?php
namespace Bugarinov\ChainValidation;

/**
 * Abstract class for the links in the chain which contains the 
 * validation processes defined by the user. 
 * 
 * @package  Bugarinov\ChainValidation
 * @author   Yuliy Bugarinov <bugarindev@yahoo.com>
 * @version  0.1.3
 * @access   public
 */
abstract class AbstractLink
{
    /**
     * @var AbstractLink
     */
    private $next;

    /**
     * @var bool
     */
    private $hasError_ = false;

    /**
     * @var string
     */
    protected $errorMessage = null;

    /**
     * @var int
     */
    protected $errorCode = 0;

    /**
     * @param string $message
     * 
     * @return null
     */
    protected function throwError(string $message, int $errorCode = 0)
    {
        $this->hasError_ = true;
        $this->errorMessage = $message;
        $this->errorCode = $errorCode;

        return null;
    }

    /**
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->hasError_;
    }

    /**
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * Set the next link to be executed if the 
     * validation within this link succeeds.
     * 
     * @param AbstractLink $next
     * 
     * @return AbstractLink
     */
    public function setNext(AbstractLink $next): AbstractLink
    {
        $this->next = $next;
        return $this;
    }

    /**
     * Execute the validations within this link
     * and return the appropriate response
     * 
     * @param array $data
     * 
     * @return array
     */
    abstract public function execute(?array $data): ?array;


    /**
     * Execute the next link in the chain
     */
    protected function executeNext(?array $data): ?array
    {
        if ($this->next == null) {
            return $data;
        } else {

            // Execute the next link
            $data = $this->next->execute($data);
            
            // Get the error messages from the executed
            // next link and pass the error data to this
            // link. This is to ensure that the error data
            // will be passed to the executor link / first link
            // in the chain. See getError() function in
            // ChainValidation class
            $this->hasError_ = $this->next->hasError();
            $this->errorMessage = $this->next->getError();
            $this->errorCode = $this->next->getErrorCode();

            return $data;
        }
    }
}