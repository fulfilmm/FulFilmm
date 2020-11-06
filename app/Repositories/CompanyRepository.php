<?php
namespace App\Repositories;

use App\Models\Company;
use App\Repositories\Contracts\DepartmentContract;

class CompanyRepository extends BaseRepository implements DepartmentContract
{

    public function model()
    {
        return Company::class;
    }
}
