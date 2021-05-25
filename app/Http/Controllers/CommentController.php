<?php

namespace App\Http\Controllers;

use App\Models\ActivityComment;
use App\Models\AssignmentComment;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $path = '';

        if ($request->file('file')) {
            $uploadedFile = $request->file('file');
            $path = Storage::url($uploadedFile->store('attachments', ['disk' => 'public']));
        }

        $data['commenter_id'] = auth('employee')->id();
        $data['file'] = $path;
        // dd($data);

        if (isset($request->activity_id)) ActivityComment::create($data);
        if (isset($request->assignment_id)) AssignmentComment::create($data);

        return redirect()->back()->with('success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
