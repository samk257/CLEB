<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutoringController extends Controller
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
            'email'  => 'required|email',
            'phone_number'  => 'required|string',
            'courses'  => 'required|string',
        ]);

        $fileName = "";
        if ($request->cv) {

            $fileName = $request->cv->getClientOriginalName();
            $path = public_path('cvs');
            $request->cv->move($path, $fileName);
        }

        $tutor = new Tutor();
        $tutor->name = $fields['name'];
        $tutor->surname = $fields['surname'];
        $tutor->email = $fields['email'];
        $tutor->phone_number = $fields['phone_number'];
        $tutor->courses = $fields['courses'];

        $tutor->save();

        return response()->json(
                [
                    'success' => true,
                    'msg' => "La classe a ete ajoute avec succes"
                ],
                200
            );
    }

    public function order_tutor(Request $request)
    {
        $fields = $request->validate([
            'name'  => 'required|string',
            'class'  => 'required|string',
            'school_attend'  => 'required|string',
            'days'  => 'required|string',
            'hours'  => 'required|string',
            'address'  => 'required|string',
            'description'  => 'required|string',
            'email'  => 'required|email',
            'phone_number'  => 'required|string',
            'type_tutoring_id'  => 'required|exists:type_tutorings,id',
            'courses'  => 'required|string',
            'user_id' =>Auth::user()->id
        ]);

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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
