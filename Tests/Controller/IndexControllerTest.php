<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class IndexControllerTest extends TestCase
{
    public function testIndexAction()
    {
        $user = new \Classes\Model\RegistrationData();
        $this->assertIsArray(\Classes\Model\RegistrationData::getArrayFromRegistrationData($user));
    }

}
