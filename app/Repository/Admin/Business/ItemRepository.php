<?php

namespace App\Repository\Admin\Business;

use App\Models\Item;
use App\Repository\AbstractRepository;
use App\Repository\Admin\Contract\ItemInterface;
use function app;

class ItemRepository extends AbstractRepository implements ItemInterface
{
    private $model = Item::class;
    private array $relationships = ['carItems.car'];
    private array $dependencies = ['carItems'];
    private array $unique = ['name'];
    private array $upload = [];

    public function __construct()
    {
        $this->model = app($this->model);
        parent::__construct($this->model, $this->relationships, $this->dependencies, $this->unique,$this->upload);
    }
   
}
