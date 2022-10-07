<?php
/**
 * This file is part of Lcobucci\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Lcobucci\JWT\Signer;

/**
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 2.1.0
 */
class KeychainTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @uses Lcobucci\JWT\Signer\Key
     *
     * @covers Lcobucci\JWT\Signer\Keychain::getPrivateKey
     */
    public function getPrivateKeyShouldReturnAKey()
    {
        $keychain = new Keychain();
        $key = $keychain->getPrivateKey('testing', 'test');

        $this->assertInstanceOf(Key::class, $key);
        $this->assertSame('testing', $key->contents());
        $this->assertSame('test', $key->passphrase());
    }

    /**
     * @test
     *
     * @uses Lcobucci\JWT\Signer\Key
     *
     * @covers Lcobucci\JWT\Signer\Keychain::getPublicKey
     */
    public function getPublicKeyShouldReturnAValidResource()
    {
        $keychain = new Keychain();
        $key = $keychain->getPublicKey('testing');

        $this->assertInstanceOf(Key::class, $key);
        $this->assertSame('testing', $key->contents());
        $this->assertSame('', $key->passphrase());
    }
}
