<?php
require_once __DIR__ . '/../BaseManager.php';
require_once __DIR__ . '/../../../utils/status.php';
require_once __DIR__ . '/../../../utils/parsers.php';



class UsersManager extends BaseManager{
    private Validator $val;

    public function __construct(UsersRepository $repo, Validator $val){
        parent::__construct($repo);
        $this->val = $val;
    }

    /**
     * Call to the users repository to create a new user in the system.
     * @param array $data The array with the data of the new user
     * @return array return an array with information about the creation
     *               succesful or not
     */
    public function create(array $data): array{
        $user = parent::create($data);
        if(isset($user['internal_code'])){
            switch($user['internal_code']){
                case '23000':
                    $key = Parser::dbDuplicateErrorParser($user['details']);
                    return statusError("recourse $key already exist in the system", 409);
                    break;
            }
        }
        return $user;
    }

    public function read(array $conditions = [], array $cols = ['*']): array{
        $user = parent::read($conditions, $cols);
        if(isset($user['internal_code'])){
            switch($user['internal_code']){
                case "42S22":
                    $key = Parser::dbColumnNotFoundParser($user['details']);
                    return statusError("unknown column '$key'", 400);
                    break;
            }
        }
        return $user;
    }
    
    public function update(array $data, array $conditions = []): array{
        $user = parent::update($data, $conditions);
        if(isset($user['internal_code'])){
            switch($user['internal_code']){
                case "42S22":
                    $key = Parser::dbColumnNotFoundParser($user['details']);
                    return statusError("unknown column '$key'", 400);
                    break;
                
                case "23000":
                    $key = Parser::dbDuplicateErrorParser($user['details']);
                    return statusError("recourse $key already exist in the system", 409);
                    break;                    
            }
        }
        return $user;
    }

    public function delete(array $conditions = []): array{
        $user = parent::delete($conditions);
        if(isset($user['internal_code'])){
            switch($user['internal_code']){
                case "42S22":
                    $key = Parser::dbColumnNotFoundParser($user['details']);
                    return statusError("unknown column '$key'", 400);
                    break;
                default:
                    return statusError($user['details'], $user['internal_code']);
            }
        }
        return $user;
    }
}