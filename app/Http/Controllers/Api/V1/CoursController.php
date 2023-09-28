<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\TypeCours;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name'  => 'required|string',
            'type_cours_id'  => 'required|exists:type_cours,id',
        ]);

        $course = new Course();
        $course->name = $fields['name'];
        $course->type_cours_id = $fields['type_cours_id'];

        $course->save();

        return response()->json(
                [
                    'success' => true,
                    'msg' => "La classe a ete ajoute avec succes"
                ],
                200
            );
    }

    public function addtypecourse(Request $request)
    {
        $fields = $request->validate([
            'name'  => 'required|string',
        ]);

        $type_course = new TypeCours();
        $type_course->name = $fields['name'];

        $type_course->save();

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
    }
}
