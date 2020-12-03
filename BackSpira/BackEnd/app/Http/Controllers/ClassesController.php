<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classes::get();

        return response()->json([
            'classes' => $classes
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
        $existsClass = Classes::where('name','=',$request->name)
        ->where('intensity','=',$request->intensity)
        ->get();

        if ($existsClass->isEmpty())
        {
            $newClass = new Classes();
            $newClass->name = $request->name;
            $newClass->intensity = $request->intensity;
            $newClass->save();

            $successClass = Classes::where('name','=',$request->name)
            ->where('intensity','=',$request->intensity)
            ->first();

            if ($successClass != null)
            {
                return response()->json([
                    'success' => true,
                    'error' => '',
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'error' => 'unkown',
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'error' => 'class',
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
        $class = Classes::find($id);

        if ($class != null)
        {
            return response()->json([
                'success' => true,
                'class' => $class,
                'error' => ''
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'class' => '',
                'error' => 'class'
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
        $class = Classes::find($id);

        if ($class != null)
        {
            $existsName = Classes::where('name','=',$request->name)
            ->where('intensity','=',$request->intensity)
            ->where('id','<>',$id)
            ->get();

            if ($existsName->isEmpty())
            {
                $class->name=$request->name;
                $class->intensity=$request->intensity;
                $class->save();

                $successClass = Classes::where('name','=',$request->name)
                ->where('intensity','=',$request->intensity)
                ->where('id','=',$id)
                ->first();

                if ($successClass != null)
                {
                    return response()->json([
                        'success' => true,
                        'classes' => $successClass,
                        'error' => '',
                    ]);
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'classes' => '',
                        'error' => 'unkown',
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'classes' => '',
                    'error' => 'class&intensity',
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'classes' => '',
                'error' => 'class',
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
        $class = Classes::find($id);

        if ($class != null)
        {
            $class->delete();

            $classDelete = Classes::find($id);

            if ($classDelete == null)
            {
                return response()->json([
                    'success' => true,
                    'error' => '',
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'error' => 'unkown',
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'error' => 'class',
            ]);
        }
    }
}
