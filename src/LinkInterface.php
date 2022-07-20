<?php
namespace Bugarinov\ChainValidation;

/**
 * Interface for a chain link
 * 
 * @package  Bugarinov\ChainValidation
 * @author   Yuliy Bugarinov <bugarindev@yahoo.com>
 * @version  0.1.5
 * @access   public
 */
interface LinkInterface
{
    function hasError(): bool;
    function getError(): ?string;
    function getErrorCode(): int;
    function setNext(LinkInterface $next): LinkInterface;
    function throwError(string $message, int $errorCode = 0);
    function execute(?array $data): ?array;
}