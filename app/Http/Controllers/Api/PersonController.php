<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $person = Person::all();
        // return  PersonResource::collection($person)->additional([
        //     'status' => true,
        //     'message' => 'Data Berhasil ditemukan'
        // ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil ditemukan!',
            'data' => $person
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
        ]);
        if($validator->fails())
        {
        return response()->json([
            'status' => false,
            'message' => 'Error',
            'error' => $validator->errors()
        ],422);
        }
       $person = Person::create($request->all());
       return  (new PersonResource($person))->additional([
            'status' => true,
            'message' => 'Data Berhasil Ditambahkan'
        ]);
        // return response()->json([
        //     'status' => true,
        //     'message' => 'Data Berhasil Ditambahkan',
        //     'data' => $person
        // ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $person = Person::findOrFail($id);
        return  (new PersonResource($person))->additional([
            'status' => true,
            'message' => 'Data Berhasil ditemukan'
        ]);

        if(!$person) {
            return response()->json([
            'status' => false,
            'message' => 'Data id tidak ditemukan',

        ]);
        }
        // return response()->json([
        //     'status' => true,
        //     'message' => 'Data id ditemukan',
        //     'data' => $person
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'email' => 'required|email'
        ]);
        if($validator->fails())
        {
        return response()->json([
            'status' => false,
            'message' => 'Error',
            'error' => $validator->errors()
        ],422);
        }
    $person = Person::find($id);
    $person->update($request->all());
    return (new PersonResource($person))->additional([
        'status' => true,
        'message' => 'Data Berhasil Diupdate'
    ]);
        // return response()->json([
        //     'status' => true,
        //     'message' => 'Data Berhasil Diupdate',
        //     'data' => $person
        // ],200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $person = Person::find($id);
        $person->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Dihapus',
            'data' => $person
        ],200);
    }
}
