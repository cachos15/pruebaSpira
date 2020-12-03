<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::get();

        return response()->json([
            'users' => $user
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
        $existsMail = User::where('mail','=',$request->mail)
        ->get();

        if ($existsMail->isEmpty())
        {
            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->mail = $request->mail;
            $newUser->password = sha1($request->password);
            $newUser->tel = $request->tel;
            $newUser->id_type = $request->id_type;
            $newUser->save();

            $successUser = User::where('name','=',$request->name)
            ->where('mail','=',$request->mail)
            ->where('password','=',sha1($request->password))
            ->where('tel','=',$request->tel)
            ->where('id_type','=',$request->id_type)
            ->get();

            if ($successUser->isEmpty())
            {
                return response()->json([
                    'success' => false,
                    'error' => 'unkown'
                ]);
            }
            else
            {
                return response()->json([
                    'success' => true,
                    'error' => ''
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'error' => 'mail'
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
        $user = User::find($id);

        if ($user != null)
        {
            return response()->json([
                'success' => true,
                'user' => $user,
                'error' => ''
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'user' => '',
                'error' => 'user'
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
        $user = User::find($id);

        if ($user != null)
        {
            $existsMail = User::where('mail','=',$request->mail)
            ->where('id','<>',$id)
            ->get();

            if ($existsMail->isEmpty())
            {
                $user->name = $request->name;
                $user->mail = $request->mail;
                $user->tel = $request->tel;
                $user->save();

                $successUser = User::where('name','=',$request->name)
                ->where('mail','=',$request->mail)
                ->where('tel','=',$request->tel)
                ->first();

                if ($successUser == null)
                {
                    return response()->json([
                        'success' => false,
                        'user' => '',
                        'error' => 'unkown'
                    ]);
                }
                else
                {
                    return response()->json([
                        'success' => true,
                        'user' => $successUser,
                        'error' => ''
                    ]);
                } 
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'user' => '',
                    'error' => 'mail'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'user' => '',
                'error' => 'user'
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
        $user = User::find($id);

        if ($user != null)
        {
            if ($user["id_type"] == 2)
            {
                $user->delete();

                $userDelete = User::find($id);
    
                if ($userDelete == null)
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
                    'error' => 'teacher'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'error' => 'user'
            ]);
        }
    }

    public function login(Request $request)
    {
        $existsMail = User::where('mail','=',$request->mail)
        ->get();

        if (!$existsMail->isEmpty())
        {
            $login = User::where('mail','=',$request->mail)
            ->where('password','=',sha1($request->password))
            ->first();

            if ($login != null)
            {
                return response()->json([
                    'success' => true,
                    'user' => $login,
                    'error' => ''
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'user' => '',
                    'error' => 'password'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'user' => '',
                'error' => 'mail'
            ]);
        }
    }
}
