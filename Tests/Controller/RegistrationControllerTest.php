<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

// use Classes\Model;
// use Classes\Service;

final class RegistrationControllerTest extends TestCase
{
    public function dbConnection(int $num, int $num2)
    {
        $userDataMockBuilder = $this->getMockBuilder(\Classes\Model\RegistrationData::class);
        $userDataMock = $userDataMockBuilder->setMethods(['fetch_assoc'])->getMock();
        $userDataMock->num_rows = $num;
        $userDataMock->affected_rows = $num2;
        $userDataMock->username = 'Lilly123';
        $userDataMock->password = 'Test';
        $userDataMock->firstName = 'Lilly';
        $userDataMock->name = 'Fee';
        $userDataMock->birthdate = '1970-08-10';
        $userDataMock->emailAdress = 'lilly@fee.de';
       
        $dbConnectionBuilder = $this->getMockBuilder(stdClass::class);
        $dbConnectionMock = $dbConnectionBuilder->setMethods(['query', 'insert_id'])->getMock();
        $dbConnectionMock->method('query')->willReturn($userDataMock);
        $dbConnectionMock->insert_id = '1';
        $dbConnectionMock->affected_rows = $num2;
        $dbConnectionMock->error = "Fehlermeldung";

        $dbStub = $this->createStub(\Classes\Model\DatabaseModel::class);

        $dbStub->method('getConnection')->willReturn($dbConnectionMock);

        // clean the instance of the singleton to make mocking possible
        $this->ref = new \ReflectionProperty('\Classes\Model\DatabaseModel', 'instance');
        $this->ref->setAccessible(true);
        $this->ref->setValue(null, $dbStub);

        return $userDataMock;
    }
 

    public function createMockView()
    {
        $viewMockBuilder = $this->getMockBuilder(\Classes\View\BaseView::class);
        $viewMockBuilder->setMethods(['setVars', 'render']);
        $viewMockBuilder->setConstructorArgs(['.', 'Registration', 'registration']);
        $viewMock = $viewMockBuilder->getMock();

        return $viewMock;
    }
    
    
    /**
    * @runInSeparateProcess
    */
    public function testRegistrationAction()
    {
        $userdata = new \Classes\Model\RegistrationData();
        $userDataMock = $this->dbConnection(0, 1);
        
        $userdata->InsertUserdata($userDataMock);
        $viewMock = $this->createMockView();

        $_POST["username"] = 'Lilly';
        $_POST["password"] = '123ABab.';
        $_POST["firstName"] = 'Lilly';
        $_POST["name"] = 'Fee';
        $_POST["birthdate"] = '1970-05-20';
        $_POST["emailAdress"] = 'lilly@fee.de';
        $_POST["submit"] = true;

        $registrationController = new \Classes\Controller\RegistrationController();
        $registrationController->setView($viewMock);
        $this->assertTrue($registrationController->registrationAction());
    }
}
