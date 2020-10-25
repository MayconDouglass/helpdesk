<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property int $id_usuario
 * @property int $cargo_cod
 * @property string $nome
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property int $ativo
 * @property int $usucad
 * @property Carbon $data_cad
 * @property Carbon|null $data_alt
 * 
 * @property Usuario $usuario
 * @property Cargo $cargo
 * @property Collection|Post[] $posts
 * @property Collection|TicketAnexo[] $ticket_anexos
 * @property Collection|TicketPost[] $ticket_posts
 * @property Collection|UserComentario[] $user_comentarios
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuarios';
	protected $primaryKey = 'id_usuario';
	public $timestamps = false;

	protected $casts = [
		'cargo_cod' => 'int',
		'ativo' => 'int',
		'usucad' => 'int'
	];

	protected $dates = [
		'data_cad',
		'data_alt'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'cargo_cod',
		'nome',
		'email',
		'password',
		'remember_token',
		'ativo',
		'usucad',
		'data_cad',
		'data_alt'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'usucad');
	}

	public function cargo()
	{
		return $this->belongsTo(Cargo::class, 'cargo_cod');
	}

	public function posts()
	{
		return $this->hasMany(Post::class, 'user_alt');
	}

	public function ticket_anexos()
	{
		return $this->hasMany(TicketAnexo::class, 'operador');
	}

	public function ticket_posts()
	{
		return $this->hasMany(TicketPost::class, 'operador');
	}

	public function user_comentarios()
	{
		return $this->hasMany(UserComentario::class, 'operador');
	}

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'usucad');
	}
}
