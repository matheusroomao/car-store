<?php

namespace App\Repository\Admin\Business;

use App\Models\Brand;
use App\Repository\AbstractRepository;
use App\Repository\Admin\Contract\BrandInterface;

class BrandRepository extends AbstractRepository implements BrandInterface
{
    private $model = Brand::class;
    private array $relationships = ['cars'];
    private array $dependencies = ['cars'];
    private array $unique = ['name'];
    private array $upload = [];

    public function __construct()
    {
        $this->model = app($this->model);
        parent::__construct($this->model, $this->relationships, $this->dependencies, $this->unique,$this->upload);
    }
   
}
