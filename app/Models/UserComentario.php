<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserComentario
 * 
 * @property int $id_comentario
 * @property int|null $cli_user
 * @property int|null $operador
 * @property bool $tipo
 * 
 * @property Usuario|null $usuario
 *
 * @package App\Models
 */
class UserComentario extends Model
{
	protected $table = 'user_comentario';
	protected $primaryKey = 'id_comentario';
	public $timestamps = false;

	protected $casts = [
		'cli_user' => 'int',
		'operador' => 'int',
		'tipo' => 'bool'
	];

	protected $fillable = [
		'cli_user',
		'operador',
		'tipo'
	];

	public function cli_user()
	{
		return $this->belongsTo(CliUser::class, 'cli_user');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'operador');
	}
}
