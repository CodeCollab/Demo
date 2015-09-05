<?php declare(strict_types=1);
/**
 * Defuse key generator
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    Encryption
 * @subpackage Defuse
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace CodeCollab\Encryption\Defuse;

use CodeCollab\Encryption\Key as KeyInterface;
use Crypto;
use CodeCollab\Encryption\CryptoException;

/**
 * Defuse key generator
 *
 * @category   CodeCollab
 * @package    Encryption
 * @subpackage Defuse
 * @author     Pieter Hordijk <info@pieterhordijk.com
 */
class Key implements KeyInterface
{
    /**
     * Generates a new key
     *
     * @return string The generated key
     *
     * @throw \CodeCollab\Encryption\CryptoException When not being able to create a sufficient strong key
     */
    public function generate(): string
    {
        try {
            return Crypto::createNewRandomKey();
        } catch(\Exception $e) {
            throw new CryptoException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
