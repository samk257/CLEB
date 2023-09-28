<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Classe::all();
        return $classes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name'  => 'required|string',
        ]);

        $classe = new Classe();
        $classe->name = $fields['name'];

        $classe->save();

        return response()->json(
                [
                    'success' => true,
                    'msg' => "La classe a ete ajoute avec succes"
                ],
                200
            );

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fields = $request->validate([
            'name'  => 'required|string',
        ]);

        $users=Classe::where('id',$id)->update([
            'name' => $fields['name'],
            ]);
            return response()->json(
                [
                    'success' => false,
                    'msg' => "La classe a ete modifie avec succes"
                ],
                200
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
