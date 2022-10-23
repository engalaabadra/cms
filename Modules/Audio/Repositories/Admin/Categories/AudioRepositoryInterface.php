<?php
namespace Modules\Audio\Repositories\Admin\Categories;

interface AudioRepositoryInterface
{
   public function getAllCategoriesPaginate($model,$request);
}
