<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class ValidationServiceTest extends TestCase
{
    private $userDataMock;

    public function setUp(): void
    {
        $this->registrationData = new Classes\Model\RegistrationData();
        $this->validate = new Classes\Service\ValidationService($this->registrationData);
    }
    
    public function dbConnection(int $num)
    {
        $this->userDataMock = $this->getMockBuilder(\Classes\Model\RegistrationData::class)->setMethods(['fetch_assoc'])->getMock();
        $this->userDataMock->num_rows = $num;
        $this->userDataMock->username = 'Lilly123';
        $this->userDataMock->password = 'Test';
        $this->userDataMock->firstName = 'Lilly';
        $this->userDataMock->name = 'Fee';
        $this->userDataMock->birthdate = '1970-08-10';
        $this->userDataMock->emailAdress = 'lilly@fee.de';

        $dbMock = $this->getMockBuilder(stdClass::class)->setMethods(['query'])->getMock();
    
        $dbMock->method('query')->willReturn($this->userDataMock);
  
        $dbStub = $this->createStub(\Classes\Model\DatabaseModel::class);
        $dbStub->method('getConnection')->willReturn($dbMock);

        // clean the instance of the singleton to make mocking possible
        $this->ref = new \ReflectionProperty('\Classes\Model\DatabaseModel', 'instance');
        $this->ref->setAccessible(true);
        $this->ref->setValue(null, $dbStub);
    }
    //username
    public function testUsernameIsValid(): void
    {
        $this->dbConnection(0);
        $this->registrationData->username = $this->userDataMock->username;
        $this->assertTrue($this->validate->isUsernameValid());
    }
    
    public function testUsernameAlreadyTaken(): void
    {
        $this->dbConnection(1);
        $this->registrationData->username = "existing Name";
        $this->assertFalse($this->validate->isUsernameValid());
    }
    
    public function testUsernameIsEmpty(): void
    {
        // $this->dbConnection();
        $this->registrationData->username = "";
        $this->assertFalse($this->validate->isUsernameValid());
    }
    
    public function testUsernameHasOnlyWhitespace(): void
    {
        // $this->dbConnection(0);
        $this->registrationData->username = " ";
        $this->assertFalse($this->validate->isUsernameValid());
    }

    //EmailAdress
    public function testEmailIsValid(): void
    {
        $this->registrationData->emailAdress = "theresa@felder.jetzt";
        $this->assertTrue($this->validate->isEmailValid());
    }
    
    public function testEmailWithoutAt(): void
    {
        $this->registrationData->emailAdress = "lilly-fee.de";
        $this->assertFalse($this->validate->isEmailValid());
    }

    public function testEmailIsEmpty(): void
    {
        $this->registrationData->emailAdress = "";
        $this->assertFalse($this->validate->isEmailValid());
    }
    
    public function testHasEmailOnlyWhitespace(): void
    {
        $this->registrationData->emailAdress = " ";
        $this->assertFalse($this->validate->isEmailValid());
    }
    //name and firstName
    public function testIsNameValid(): void
    {
        $this->registrationData->name = "Herold";
        $this->registrationData->firstName = "Lilly";
        
        $this->assertTrue($this->validate->isNameValid());
    }

    public function testIsNameEmpty(): void
    {
        $this->registrationData->name = "";
        $this->registrationData->firstName = "";
        $this->assertFalse($this->validate->isNameValid());
    }

    public function testHasNameOnlyWhitespace(): void
    {
        $this->registrationData->name = " ";
        $this->registrationData->firstName = " ";
        $this->assertFalse($this->validate->isNameValid());
    }

    /*public function testHasNameOnlyNumbergs(): void
    {
        $this->registrationData->name = "354631684";
        $this->registrationData->firstName = "354354654645";
        $this->assertFalse($this->validate->isNameValid());
    } */
   

    //password
    public function testIsPasswordValid(): void
    {
        $this->registrationData->password = "123ABab.";
        $this->assertTrue($this->validate->isPasswordValid());
    }

    public function testPasswordIsTooShort(): void
    {
        $this->registrationData->password = "12Ab.";
        $this->assertFalse($this->validate->isPasswordValid());
    }

    public function testPasswordHasNoNumbers(): void
    {
        $this->registrationData->password = "asdfABab..";
        $this->assertFalse($this->validate->isPasswordValid());
    }

    public function testPasswordHasNoLetters(): void
    {
        $this->registrationData->password = "1451345..";
        $this->assertFalse($this->validate->isPasswordValid());
    }

    public function testPasswordHasNoSpecialChar(): void
    {
        $this->registrationData->password = "1451345AAbb";
        $this->assertFalse($this->validate->isPasswordValid());
    }

    public function testPasswordIsEmpty(): void
    {
        $this->registrationData->password = "";
        $this->assertFalse($this->validate->isPasswordValid());
    }

    public function testPasswordHasOnlyWhitespace(): void
    {
        $this->registrationData->password = " ";
        $this->assertFalse($this->validate->isPasswordValid());
    }

    //birthdate

    public function testIsBirthdateValid(): void
    {
        $this->registrationData->birthdate = "1976-01-20";
        $this->assertTrue($this->validate->validateBirthdate());
    }

    public function testBirthdateIsInFuture(): void
    {
        $this->registrationData->birthdate = "2021-01-20";
        $this->assertFalse($this->validate->validateBirthdate());
    }

    public function testIsBirthdateEmpty(): void
    {
        $this->registrationData->birthdate = "";
        $this->assertFalse($this->validate->validateBirthdate());
    }

    public function testBirthdateHasOnlyWhitespace(): void
    {
        $this->registrationData->birthdate = " ";
        $this->assertFalse($this->validate->validateBirthdate());
    }

    //isRegistrationValid

    public function testIsRegistrationValid()
    {
        $reflector = new ReflectionClass("\Classes\Service\ValidationService");
        $property = $reflector->getProperty("registrationDataValid");
        $property->setAccessible(true);
        

        $validationData = new \Classes\Model\RegistrationData();
        $validationData->username = "Lilly123";
        $validationData->password = "123ABab.";
        $validationData->birthdate = "1976-01-20";
        $validationData->emailAdress = "lilly@fee.de";
        $validationData->firstName = "Lilly";
        $validationData->name = "Fee";
        
        $property->setValue($this->validate, $validationData);

        $this->assertTrue($this->validate->isRegistrationValid());
    }

    public function testIsRegistrationNOTValid(): void
    {
        $reflector = new ReflectionClass("\Classes\Service\ValidationService");
        $property = $reflector->getProperty("registrationDataValid");
        $property->setAccessible(true);
        

        $validationData = new \Classes\Model\RegistrationData();
        $validationData->username = "";
        $validationData->password = "123ABab.";
        $validationData->birthdate = "1976-01-20";
        $validationData->emailAdress = "lilly@fee.de";
        $validationData->firstName = "Lilly";
        $validationData->name = "Fee";
        
        $property->setValue($this->validate, $validationData);

        $this->assertFalse($this->validate->isRegistrationValid());
    }

    public function testGetRegistrationDataValid()
    {
        $this->assertIsObject($this->registrationData);
    }
}
