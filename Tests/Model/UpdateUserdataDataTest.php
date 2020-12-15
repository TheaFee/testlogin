<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class UpdateUserdataDataTest extends TestCase
{
    public function dbConnection(int $num)
    {

        $dbConnection = $this->getMockBuilder(stdClass::class);
        $dbMock = $dbConnection->setMethods(['query', 'error'])->getMock();
        $dbMock->affected_rows = $num;

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
    public function testUpdateUserdata()
    {$this->dbConnection(1);
        $userdata = new \Classes\Model\UpdateUserdataData();
        
        $userdata->username = "Lilly123";
        $userdata->password = "123ABab.";
        $userdata->firstName = "Lilly";
        $userdata->name = "Fee";
        $userdata->birthdate = "1970-05-20";
        $userdata->emailAdress = "lilly@fee.de";

        $userID = 1;

        $this->assertTrue($userdata->updateUserdata($userdata, $userID));
    }

    public function testUpdateUserdataFALSE()
    {$this->dbConnection(0);
        $userdata = new \Classes\Model\UpdateUserdataData();
        
        $userdata->username = "Lilly123";
        $userdata->password = "123ABab.";
        $userdata->firstName = "Lilly";
        $userdata->name = "Fee";
        $userdata->birthdate = "1970-05-20";
        $userdata->emailAdress = "lilly@fee.de";

        $userID = 1;

        $this->assertFalse($userdata->updateUserdata($userdata, $userID));
    }
}