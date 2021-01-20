<?php
namespace Bugarinov\ChainValidation;

/**
 * The class for executing the links in sequence.
 * 
 * @package  Bugarinov\ChainValidation
 * @author   Yuliy Bugarinov <bugarindev@yahoo.com>
 * @version  0.1.0
 * @access   public
 */
class ChainValidation
{
    /**
     * @var AbstractLink[]
     */
    private $links;

    public function __construct()
    {
        $this->links = [];
    }

    /**
     * Add the link to the validation list
     */
    public function add(AbstractLink $link): ChainValidation
    {
        // Get the current count of validation links
        $linkCount = count($this->links);

        // Get the last link and set the new link
        // as the next link
        if ($linkCount > 0) {
            $lasLink = $this->links[$linkCount - 1];
            $lasLink->setNext($link);
        }

        // Add the new link to the collection
        $this->links[] = $link;

        return $this;
    }

    /**
     * Execute the validations
     * 
     * @var array $data
     * 
     * @return array|null
     */
    public function execute(array $data): ?array
    {
        return $this->links[0]->execute($data);
    }

    /**
     * Return the error status of the chain
     * execution
     * 
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->links[0]->hasError();
    }

    /**
     * Return the error message that occured
     * during the chain execution
     * 
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->links[0]->getError();
    }
}