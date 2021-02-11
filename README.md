# example1

пример работы Repository + DataMapper + Entity

# example2

пример работы с моделью Propel2 в многослойной архитектуре Controller -> Service -> Repostitory -> Model

# example3

пример работы с моделью Propel2 в многослойной архитектуре без репозитория Controller -> Service -> Model

# example4

Пример луковой архитектуры с разделением на Presentation, Application, Domain, Infrastructure

```
  src/
    | Presentation
    |   | Controllers
    |   |   | UserController.php    
    | Application/
    |   | Commands/
    |   |   | Registration/
    |   |   |   | RegistrationManager/
    |   |   |   | RegistrationUser/
    |   |   |   |    | RegistrationUserCommand.php
    |   |   |   |    | RegistrationUserHandler.php
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
```    
  
# example5

Пример луковой архитектуры с разделением на Presentation, Application, Domain, Infrastructure
и группировкой бизнес логики
```
  src
    | Presentation
    |   | Controllers
    |   |   | UserController.php
    |   | Modules
    |   | Views
    | Application
    |   | Office
    |   |   | OfficeService.php
    |   |   | RegistrationManager
    |   |   | RegistrationUser
    |   |   |    | RegistrationUserCommand.php
    |   |   |    | RegistrationUserHandler.php
    | Domain/
    |   | User/
    |   |   | Contracts
    |   |   |   | UserCriteriaInterface.php
    |   |   |   | UserRepositoryInterface.php       
    |   |   | Exceptions
    |   |   | UserCollection.php
    |   |   | UserEntity.php
    |   |   | UserService.php
    | Infrastructure
    |   | Repositories
    |   |   | User
    |   |   |   | UserCriteria.php
    |   |   |   | UserRepository.php  
```  
##  phpmetrics
```  
$ ./vendor/bin/phpmetrics --report-html=./docs/myreport4 ./src/example4
```