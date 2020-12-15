<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class RegistrationDataTest extends TestCase
{
    public function dbConnection(int $num)
    {

        $dbConnection = $this->getMockBuilder(stdClass::class);
        $dbMock = $dbConnection->setMethods(['query'])->getMock();
        $dbMock->affected_rows = $num;
        $dbMock->insert_id = '1';
        $dbMock->error = "Fehlermeldung";

        $dbStub = $this->createStub(\Classes\Model\DatabaseModel::class);

        $dbStub->method('getConnection')->willReturn($dbMock);

        // clean the instance of the singleton to make mocking possible
        $this->ref = new \ReflectionProperty('\Classes\Model\DatabaseModel', 'instance');
        $this->ref->setAccessible(true);
        $this->ref->setValue(null, $dbStub);
    }
 
    /**
     * @runInSeparateProcess
     */
    public function testInsertUserdata()
    {$this->dbConnection(1);
        $userdata = new \Classes\Model\RegistrationData();
        
        $userdata->username = "Lilly123";
        $userdata->password = "123ABab.";
        $userdata->firstName = "Lilly";
        $userdata->name = "Fee";
        $userdata->birthdate = "1970-05-20";
        $userdata->emailAdress = "lilly@fee.de";

        $this->assertTrue($userdata->InsertUserdata($userdata));
    }

    public function testInsertUserdataFALSE()
    {$this->dbConnection(0);
        $userdata = new \Classes\Model\RegistrationData();
        
        $userdata->username = "Lilly123";
        $userdata->password = "123ABab.";
        $userdata->firstName = "Lilly";
        $userdata->name = "Fee";
        $userdata->birthdate = "1970-05-20";
        $userdata->emailAdress = "lilly@fee.de";

        $this->assertFalse($userdata->insertUserdata($userdata));
    }
}
