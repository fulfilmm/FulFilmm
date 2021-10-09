<?php

namespace App\Http\Controllers;

use App\Exports\CompaniesExport;
use App\Exports\EmployeeExport;
use App\Http\Requests\CompanyRequest;
use App\Imports\CompanyImport;
use App\Models\Company;
use App\Repositories\Contracts\CompanyContract;
use App\Repositories\Contracts\DepartmentContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        //data are displayed by livewire
        return view('company.data.lists');
    }

    public function card(){
        $companies = Company::paginate(20);
        return view('company.data.cards', compact('companies'));
    }

    public function import(Request $request)
    {
        // dd($request);
        try {
            Excel::import(new CompanyImport, $request->file('import'));
            return redirect()->route('companies.index')->with('success', __('alert.import_success'));
        } catch (Exception $e) {
            // dd($e);
            return redirect()->route('companies.index')->with('error', $e->getMessage());
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $hasSetUp = $this->company_contract->isUserCompany();
        $parent_companies = $this->company_contract->parentCompanies()->pluck('name', 'id')->all();
        return view('company.create', compact('parent_companies', 'hasSetUp'));
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
        dd($request->all());
        $data=$request->all();
        $path = '';
        if ($request->file('logo')) {
            $uploadedFile = $request->file('logo');
            $path = Storage::url($uploadedFile->store('companylogo', ['disk' => 'public']));
            $data['logo'] = $request->logo->getClientOriginalName();
            $data['logo'] = $path;
        }

        $this->company_contract->create($data);
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
        $record = $this->company_contract->with('parentCompany')->getById($id);
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
        $hasSetUp = $this->company_contract->isUserCompany();
        $parent_companies = $this->company_contract->parentCompanies()->pluck('name', 'id')->all();
        $record = $this->company_contract->getById($id);
        return view('company.edit', compact('record', 'parent_companies', 'hasSetUp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $data=$request->all();
        $path = '';
        if ($request->file('logo')) {
            $uploadedFile = $request->file('logo');
            $path = Storage::url($uploadedFile->store('companylogo', ['disk' => 'public']));
            $data['logo'] = $request->logo->getClientOriginalName();
            $data['logo'] = $path;
        }

        $this->company_contract->updateById($id, $data);
        return redirect()->route('companies.index')->with('success', __('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //
        $this->company_contract->deleteById($id);
        return redirect()->route('companies.index')->with('success', __('alert.delete_success'));
    }
}
