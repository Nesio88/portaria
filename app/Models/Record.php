<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Record extends Model
{
    use HasFactory;

    protected $table = 'records';
    protected $primaryKey = 'id';

    protected $fillable = [
        "deliveryman_id",
        "empresa",
        "bloco",
        "apartamento",
        "status"
    ];

    protected $guarded  = [
        'id', 'created_at', 'updated_at' 
    ];

    /**
     * 
     */
    public static function listCheckin() 
    {
        try {

            $dados = array();
            $qry = DB::select("SELECT A.id, B.name, DATE_FORMAT(A.created_at,'%d/%m/%Y %H:%i:%s') as entrada  
                                FROM records AS A
                                    LEFT JOIN deliverymans B ON(A.deliveryman_id = B.id)
                                WHERE A.status IN(1)");

            foreach ($qry as $resultados) {
                $dados[] = $resultados;
            }

        } catch (Exception $e) {

            return response()->json([
                'mensagem' => "Tivemos um problema inesperado, tente novamente mais tarde",
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace()
            ], 402);
        }

        return $dados;
    }
}
