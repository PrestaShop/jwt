<?php
/**
 * This file is part of Lcobucci\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Lcobucci\JWT\Parsing;

/**
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 0.1.0
 *
 * @covers \Lcobucci\JWT\Encoding\CannotEncodeContent
 */
class EncoderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers Lcobucci\JWT\Parsing\Encoder::jsonEncode
     */
    public function jsonEncodeMustReturnAJSONString()
    {
        $encoder = new Encoder();

        $this->assertEquals('{"test":"test"}', $encoder->jsonEncode(['test' => 'test']));
    }

    /**
     * @test
     *
     * @covers Lcobucci\JWT\Parsing\Encoder::jsonEncode
     */
    public function jsonEncodeMustRaiseExceptionWhenAnErrorHasOccured()
    {
        $this->expectException(\RuntimeException::class);

        $encoder = new Encoder();
        $encoder->jsonEncode("\xB1\x31");
    }

    /**
     * @test
     *
     * @covers Lcobucci\JWT\Parsing\Encoder::base64UrlEncode
     */
    public function base64UrlEncodeMustReturnAnUrlSafeBase64()
    {
        $data = base64_decode('0MB2wKB+L3yvIdzeggmJ+5WOSLaRLTUPXbpzqUe0yuo=');

        $encoder = new Encoder();
        $this->assertEquals('0MB2wKB-L3yvIdzeggmJ-5WOSLaRLTUPXbpzqUe0yuo', $encoder->base64UrlEncode($data));
    }
}
