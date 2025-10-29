<?php
require_once __DIR__ . '/../BaseManager.php';
require_once __DIR__ . '/../../../utils/validator.php';
class SectionsManager extends BaseManager{
    private Validator $val;
    const TABLE = 'sections';

    public function __construct(MySQLRepositorie $repo, Validator $val){
        parent::__construct($repo);
        $this->val = $val;
    }
    
    public function create(array $data): array{
        $newGroup = $data['section_name'];
        if($this->existByGroup($newGroup)) return statusError(["group $newGroup exists yet"], 400);
        return parent::createQuery(self::TABLE, $data);
    }

    public function read(array $conditions = [], array $cols = ['*']): array{
        return parent::readQuery(self::TABLE, $conditions, $cols);
    }

    public function update(array $data, array $conditions): array{
        $newGroup = $data['section_name'];
        if($this->existByGroup($newGroup)) return statusError(["group $newGroup exists yet"], 400);
        return parent::updateQuery(self::TABLE, $data, $conditions);
    }

    public function delete(array $conditions = []): array{
        if(!$this->existByConditions($conditions)) return statusError(['nothing to delete'], 200);
        return parent::deleteQuery(self::TABLE, $conditions);
    }

    public function existByGroup(string $group){
        $conditions = [['column' => 'section_name', 'op' => '=', 'val' => $group, 'bool' => 'AND']];
        $columns = ['section,name'];
        $group = parent::readQuery(self::TABLE, $conditions, $columns);
        if(!empty($group)) return true;
        return false;
    }

    public function existByConditions(array $conditions){
        $columns = ['section,name'];
        $group = parent::readQuery(self::TABLE, $conditions, $columns);
        if(!empty($group)) return true;
        return false;
    }
}