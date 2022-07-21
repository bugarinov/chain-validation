<?php
namespace Bugarinov\ChainValidation;

/**
 * Interface for a chain link
 * 
 * @package  Bugarinov\ChainValidation
 * @author   Yuliy Bugarinov <bugarindev@yahoo.com>
 * @version  0.2.0
 * @access   public
 */
interface LinkInterface
{
    function hasError(): bool;
    function getError(): ?string;
    function getErrorCode(): int;
    function setNext(LinkInterface $next): LinkInterface;
    function execute(?array $data): ?array;
}