<?php

namespace App;

use App\Models\Cargo;
use App\Models\Post;
use App\Models\TicketAnexo;
use App\Models\TicketPost;
use App\Models\UserComentario;
use App\Models\Usuario;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
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

	public function build_details()
	{
		return $this->hasMany(BuildDetail::class, 'user');
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
