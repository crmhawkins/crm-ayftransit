<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TarifasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexMaritima()
    {
        $response = '';
        // $user = Auth::user();

        return view('tarifa.indexMaritima', compact('response'));
    }
    public function indexTerrestre()
    {
        $response = '';
        // $user = Auth::user();

        return view('tarifa.indexTerrestre', compact('response'));
    }
    public function indexAerea()
    {
        $response = '';
        // $user = Auth::user();

        return view('tarifa.indexAerea', compact('response'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tarifa.create');

    }
    public function subida()
    {
        return view('tarifa.subida');

    }
    public function createFromBudget()
    {
        //
        return view('tarifa.create-from-budget');

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('tarifa.edit', compact('id'));

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
