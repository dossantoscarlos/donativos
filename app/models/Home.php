<?php 

declare(strict_types=1);

namespace App\Models;

class Home {

    public const table = 'Homes'; 
    public string $name;

    public function to_array() 
    {
        return get_object_vars($this);
    }
}