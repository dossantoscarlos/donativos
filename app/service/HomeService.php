<?php 

declare(strict_types=1);


namespace App\Service;

use App\Database\Conexao;
use App\Database\RepositoryTrait;
use App\Models\Home;

class HomeService
{   

    use RepositoryTrait;

    
    public function save(Home $model)
    {
        return $this->insert($model::table, $model->to_array());
    }

    /**
     * Select all items from the Homes table
     *
     * @return array The selected items
     */
    public function all (): array
    {
       return $this->select_all('Homes');
    }
}