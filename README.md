# example1

пример работы Repository + DataMapper + Entity

# example2

пример работы с моделью Propel2 в многослойной архитектуре Controller -> Service -> Repostitory -> Model

# example3

пример работы с моделью Propel2 в многослойной архитектуре без репозитория Controller -> Service -> Model

# example4

Пример луковой архитектуры с разделением на Application, Domain, Infrastructure

  src/
    | Application/
    |   | Commands/
    |   |   | Registration/
    |   |   |   | RegistrationManager/
    |   |   |   | RegistrationUser/
    |   |   |   |    | RegistrationUserCommand.php
    |   |   |   |    | RegistrationUserHandler.php
    |   | Controllers
        |   |   | UserController.php
    | Domain/
    |   | User/
    |   |   | Contracts/
    |   |   |   | UserCriteriaInterface.php
    |   |   |   | UserRepositoryInterface.php       
    |   |   | Exceptions/
    |   |   | UserCollection.php
    |   |   | UserEntity.php
    |   |   | UserService.php
    | Infrastructure
    |   | Repositories
    |   |   | User/
    |   |   |   | UserCriteria.php
    |   |   |   | UserRepository.php
    
  или
  
  src
    | Application
    |   | Commands
    |   | Controllers
    | Domain
    |   | User
    | Infrastructure
    |   | Repositories
  
  