<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class CliUser
 * 
 * @property int $id_usuario
 * @property int $cli_cod
 * @property string $nome
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $observacao
 * @property bool $status
 * 
 * @property Cliente $cliente
 * @property Collection|TicketAnexo[] $ticket_anexos
 * @property Collection|TicketPost[] $ticket_posts
 * @property Collection|Ticket[] $tickets
 * @property Collection|UserComentario[] $user_comentarios
 *
 * @package App\Models
 */
class CliUser extends Authenticatable
{
	protected $table = 'cli_users';
	protected $primaryKey = 'id_usuario';
	public $timestamps = false;

	protected $casts = [
		'cli_cod' => 'int',
		'status' => 'bool'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'cli_cod',
		'nome',
		'email',
		'password',
		'remember_token',
		'observacao',
		'status'
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class, 'cli_cod');
	}

	public function ticket_anexos()
	{
		return $this->hasMany(TicketAnexo::class, 'cli_user');
	}

	public function ticket_posts()
	{
		return $this->hasMany(TicketPost::class, 'cli_user');
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'cli_user');
	}

	public function user_comentarios()
	{
		return $this->hasMany(UserComentario::class, 'cli_user');
	}
}
