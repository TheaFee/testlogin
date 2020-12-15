<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class LoginControllerTest extends TestCase
{
    public function dbConnection(int $num)
    {
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


    public function createMockView(){

        $viewMockBuilder = $this->getMockBuilder(\Classes\View\BaseView::class);
        $viewMockBuilder->setMethods(['setVars', 'render']);
        $viewMockBuilder->setConstructorArgs(['.', 'Login', 'login']);
        $viewMock = $viewMockBuilder->getMock();

        return $viewMock;

    }

    /**
     * @runInSeparateProcess
     */
    public function testLoginActionTrue()
    {
        $this->dbConnection(1);
        $viewMock = $this->createMockView();
        $_POST["username"] = "not exist";
        $_POST["password"] = "not exist";
       
        $loginController = new Classes\Controller\LoginController();
        $loginController->setView($viewMock);
        $this->assertTrue($loginController->loginAction());
    }
    /**
     * @runInSeparateProcess
     */
    public function testLoginActionFalse()
    {
        $this->dbConnection(0);
        $_POST["username"] = "not exist";
        $_POST["password"] = "not exist";

        $loginController = new Classes\Controller\LoginController();
        $this->assertFalse($loginController->loginAction());
    }


}
