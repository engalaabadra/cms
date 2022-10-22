<?php
namespace Modules\Audio\Repositories\Admin;

interface AudioRepositoryInterface
{
   public function getAllPaginates($model,$request);
}
