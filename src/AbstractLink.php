<?php
namespace Bugarinov\ChainValidation;

/**
 * Abstract class for the links in the chain which contains the 
 * validation processes defined by the user. 
 * 
 * @package  Bugarinov\ChainValidation
 * @author   Yuliy Bugarinov <bugarindev@yahoo.com>
 * @version  0.1.0
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
    private $hasError_;

    /**
     * @var string
     */
    protected $errorMessage;

    public function __construct()
    {
        $this->hasError_ = false;
        $this->errorMessage = null;
    }

    
    /**
     * @param string $message
     * 
     * @return null
     */
    protected function throwError(string $message)
    {
        $this->hasError_ = true;
        $this->errorMessage = $message;

        return null;
    }

    /**
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->hasError_;
    }

    public function getError(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * Set the next link to be executed in the chain if the 
     * validation within the current chain succeeds.
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
     * Execute the validations within the current link
     * andd return the appropriate response
     * 
     * @param array $data
     * 
     * @return array
     */
    abstract public function execute(array $data): ?array;


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

            return $data;
        }
    }
}