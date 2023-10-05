<?php

namespace App\Http\Controllers;
use App\Models\TypeCours;
use Illuminate\Http\Request;

class TypeCoursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $TypeCours = TypeCours::all();
        return $TypeCours;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name'  => 'required|string',
           
        ]);

        $TypeCours = new TypeCours();
        $TypeCours->name = $fields['name'];
       /// $course->type_cours_id = $fields['type_cours_id'];

        $TypeCours->save();

        return response()->json(
                [
                    'success' => true,
                    'msg' => "type_cours a ete ajoute avec succes"
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
        //
        $fields = $request->validate([
            'name'  => 'required|string',
        ]);

        $typeCours=TypeCours::where('id',$id)->update([
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
        $type_course=TypeCours::find($id);
        $type_course->delete();

        return response()->json(
            [
                
                'msg' => "deleted"
            ],
            200
        );
    }
}
