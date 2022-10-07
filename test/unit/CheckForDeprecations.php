<?php

namespace Lcobucci\JWT;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Error\Deprecated;
use function class_exists;
use function restore_error_handler;
use function set_error_handler;
use const E_USER_DEPRECATED;

trait CheckForDeprecations
{
    /** @var string[]|null */
    private $expectedDeprecationMessages;

    /** @var string[]|null */
    private $actualDeprecationMessages = [];

    /** @after */
    public function verifyDeprecationWasTrigger()
    {
        if ($this->expectedDeprecationMessages === null) {
            return;
        }

        restore_error_handler();

        if (class_exists(\PHPUnit_Framework_Error_Deprecated::class)) {
            \PHPUnit_Framework_Error_Deprecated::$enabled = true;
        } else if (property_exists(\PHPUnit\Framework\Error\Deprecated::class, 'enabled')) {
            \PHPUnit\Framework\Error\Deprecated::$enabled = true;
        }

        Assert::assertSame($this->expectedDeprecationMessages, $this->actualDeprecationMessages);

        $this->expectedDeprecationMessages = null;
        $this->actualDeprecationMessages   = [];
    }

    public function expectDeprecation($message = null): void
    {
        if ($this->expectedDeprecationMessages !== null) {
            $this->expectedDeprecationMessages[] = $message;

            return;
        }

        if (class_exists(\PHPUnit_Framework_Error_Deprecated::class)) {
            \PHPUnit_Framework_Error_Deprecated::$enabled = true;
        } else if (property_exists(\PHPUnit\Framework\Error\Deprecated::class, 'enabled')) {
            \PHPUnit\Framework\Error\Deprecated::$enabled = true;
        } else {
            //$this->expectException(Deprecated::class);
        }

        $this->expectedDeprecationMessages = [$message];

        set_error_handler(
            function ($errorNumber, $message) {
                $this->actualDeprecationMessages[] = $message;
            },
            E_USER_DEPRECATED
        );
    }
}
