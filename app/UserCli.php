<?php

namespace App;

use App\Models\Cliente;
use App\Models\Ticket;
use App\Models\TicketAnexo;
use App\Models\TicketPost;
use App\Models\UserComentario;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserCli extends Authenticatable
{
    use Notifiable;
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
