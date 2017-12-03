<?php

namespace App\Http\Controllers\Rest\Professional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Professionals\WaitingLists as WaitingListsEntity;

class WaitingListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id, WaitingListsEntity $waiting_list)
    {   
        return $waiting_list
                ->ownedBy($user_id, 'professional_id')
                ->get();
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id, WaitingListsEntity $waiting_list)
    {
        $waiting_list = $waiting_list->create($request->all());
        return response()->json([
            'waiting_list' => $waiting_list,
            'success' => isset($waiting_list->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id, WaitingListsEntity $waiting_list)
    {
        return $waiting_list->ownedBy($user_id, 'professional_id')->firstOrFail();
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id, WaitingListsEntity $waiting_list)
    {
        return response()->json([
            'waiting_list' => $waiting_list,
            'success' => $waiting_list->update($request->all())
        ]);
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
    }
}
