<?php
namespace Modules\Client\Repositories\Admin;

interface ClientRepositoryInterface
{
   public function getAllClientsPaginate($model,$request);
}
