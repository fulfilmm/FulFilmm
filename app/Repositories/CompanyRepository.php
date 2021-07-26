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

    public function parentCompanies()
    {
        return $this->model->whereNull('parent_company')->get();
    }

    public function isUserCompany(){
        return Company::userCompany()->first() ? true : false;
    }
}
