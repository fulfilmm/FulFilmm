<?php
namespace App\Repositories;

use App\Models\Company;
use App\Repositories\Contracts\CompanyContract;

class CompanyRepository extends BaseRepository implements CompanyContract
{

    public function model()
    {
        return Company::class;
    }
}
