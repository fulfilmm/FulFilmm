<?php
namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerContract;

class CustomerRepository extends BaseRepository implements CustomerContract
{

    public function model()
    {
        return Customer::class;
    }
}
