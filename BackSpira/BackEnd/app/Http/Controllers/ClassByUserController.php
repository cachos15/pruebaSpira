<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassByUser;
use App\Models\User;
use App\Models\Classes;

class ClassByUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = ClassByUser::get();

        return response()->json([
            'classByUser' => $classes
        ]);
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
    public function store(Request $request)
    {
        $existsUser = User::find($request->id_user);

        $existsClass = Classes::find($request->id_class);

        if ($existsUser != null && $existsClass != null)
        {
            $existsClassByUser = ClassByUser::where('id_user','=',$request->id_user)
            ->where('id_class','=',$request->id_class)
            ->get();

            if ($existsClassByUser->isEmpty())
            {
                $newClassByUser = new ClassByUser();
                $newClassByUser->id_user = $request->id_user;
                $newClassByUser->id_class = $request->id_class;
                $newClassByUser->save();

                $successClass = ClassByUser::where('id_user','=',$request->id_user)
                ->where('id_class','=',$request->id_class)
                ->get();

                if (!$successClass->isEmpty())
                {
                    return response()->json([
                        'success' => true,
                        'error' => ''
                    ]);
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'error' => 'unkown'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'error' => 'classByUser'
                ]);
            }
        }
        else if ($existsUser == null && $existsClass == null)
        {
            return response()->json([
                'success' => false,
                'error' => 'user&class'
            ]);
        }
        else if ($existsUser == null)
        {
            return response()->json([
                'success' => false,
                'error' => 'user'
            ]);
        }
        else if ($existsClass == null)
        {
            return response()->json([
                'success' => false,
                'error' => 'class'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classByUser = ClassByUser::getClassById($id);

        if ($classByUser != null)
        {
            return response()->json([
                'success' => true,
                'class' => $classByUser,
                'error' => ''
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'class' => '',
                'error' => 'classByUser'
            ]);
        }
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
    public function update(Request $request, $id)
    {
        $existsClass = Classes::find($request->id_class);

        if ($existsClass != null)
        {
            $classByUserExists = ClassByUser::where('id_user','=',$request->id_user)
            ->where('id_class','=',$request->id_class)
            ->where('id','<>',$id)
            ->get();

            if ($classByUserExists->isEmpty())
            {
                $classByUser = ClassByUser::find($id);
                $classByUser->id_class = $request->id_class;
                $classByUser->save();

                $successClassByUser = ClassByUser::where('id_user','=',$request->id_user)
                ->where('id_class','=',$request->id_class)
                ->get();

                if (!$successClassByUser->isEmpty())
                {
                    return response()->json([
                        'success' => true,
                        'error' => ''
                    ]); 
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'error' => 'unkown'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'error' => 'classByUser'
                ]);
            }            
        }
        else
        {

            return response()->json([
                'success' => false,
                'error' => 'class'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $classByUser = ClassByUser::find($id);

        if ($classByUser != null)
        {
            $classByUser->delete();

            $successClassByUser = ClassByUser::find($id);

            if ($successClassByUser == null)
            {
                return response()->json([
                    'success' => true,
                    'error' => ''
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'error' => 'unkown'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'error' => 'classByUser'
            ]);
        }
    }

    public function getClassesByUser(Request $request)
    {
        $existsUser = User::find($request->id_user);

        if ($existsUser != null)
        {
            $classes = ClassByUser::getClassesByUser($request->id_user);

            return response()->json([
                'success' => true,
                'classes' => $classes,
                'error' => ''
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'classes' => '',
                'error' => 'user'
            ]);
        }
    }
}
