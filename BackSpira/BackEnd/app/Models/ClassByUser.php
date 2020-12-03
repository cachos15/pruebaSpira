<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClassByUser extends Model
{
    use HasFactory;

    protected $table = 'classByUser';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_class',
    ];

    static function getClassesByUser($id_user)
    {
        $classes = DB::select("select cbu.id, c.name, c.intensity
        from class c 
        inner join classByUser cbu on c.id = cbu.id_class
        where cbu.id_user = $id_user");

        return $classes;
    }

    static function getClassById($id)
    {
        $classes = DB::select("select cbu.id, c.name, c.intensity
        from class c 
        inner join classByUser cbu on c.id = cbu.id_user
        where cbu.id = $id");

        return $classes;
    }
}
