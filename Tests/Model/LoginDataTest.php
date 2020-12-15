<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class LoginDataTest extends TestCase
{
    public function dbConnection(int $num)
    {
        parent::setUp();

        $userDataMock = $this->getMockBuilder(stdClass::class)->setMethods(['fetch_assoc'])->getMock();
        $userDataMock->num_rows = $num;
        $userDataMock->error = "Fehlermeldung";

        $array = [
            "username" => 'Lilly123',
            "password" => '123ABab.',
            "firstName" => 'Lilly',
            "name" => 'Fee',
            "birthdate" => '1970-05-20',
            "emailAdress" => 'lilly@fee.de',
            "userID" => 1
            ];
        $userDataMock->method('fetch_assoc')->willReturn($array);

        $dbMock = $this->getMockBuilder(stdClass::class)->setMethods(['query'])->getMock();

        $dbMock->method('query')->willReturn($userDataMock);
        
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
    public function testGetUserLogin()
    { $this->dbConnection(1);

        $login =  new \Classes\Model\LoginData();
        $this->assertTrue($login->getUserLogin("not exist", "not exist"));
    }


    /**
     * @runInSeparateProcess
     */
    public function testGetUserNOTLogin()
    {  $this->dbConnection(0);
 
        $login =  new \Classes\Model\LoginData();
        $this->assertFalse($login->getUserLogin("not exist", "not exist"));
    }
}