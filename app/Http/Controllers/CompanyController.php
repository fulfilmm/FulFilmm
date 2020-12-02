<?php

namespace App\Http\Controllers;

use App\Exports\CompaniesExport;
use App\Exports\EmployeeExport;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Repositories\Contracts\CompanyContract;
use App\Repositories\Contracts\DepartmentContract;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CompanyController extends Controller
{

    private $company_contract;

    public function __construct(CompanyContract $company_contract)
    {
        $this->company_contract = $company_contract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $companies = Company::get();
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $parent_companies = $this->company_contract->parentCompanies()->pluck('name','id')->all();
        return view('company.create', compact('parent_companies'));
    }

    public function export()
    {
        return Excel::download(new CompaniesExport, 'companies.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        //
        $this->company_contract->create($request->all());
        return redirect()->route('companies.index')->with('success', __('alert.create_success'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $record = $this->company_contract->getById($id);
        return view('company.show', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $parent_companies = $this->company_contract->parentCompanies()->pluck('name','id')->all();
        $record = $this->company_contract->getById($id);
        return view('company.edit', compact('record','parent_companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->company_contract->updateById($id, $request->all());
        return redirect()->route('companies.index')->with('success', __('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->company_contract->deleteById($id);
        return redirect()->route('company.index')->with('success', __('alert.delete_success'));
    }
}
