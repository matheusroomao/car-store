<?php

namespace App\Repository\Admin\Business;

use App\Models\CarItem;
use App\Repository\AbstractRepository;
use App\Repository\Admin\Contract\CarItemInterface;
use function app;

class CarItemRepository extends AbstractRepository implements CarItemInterface
{
    private $model = CarItem::class;
    private array $relationships = ['car','item'];
    private array $dependencies = [];
    private array $unique = ['name'];
    private array $upload = [];

    public function __construct()
    {
        $this->model = app($this->model);
        parent::__construct($this->model, $this->relationships, $this->dependencies, $this->unique,$this->upload);
    }
   
}
