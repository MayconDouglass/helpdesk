<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ticket
 * 
 * @property int $id_ticket
 * @property int $numero
 * @property int|null $scrum
 * @property int $cli_user
 * @property int $cli_cod
 * @property int $setor_cod
 * @property int $categoria_cod
 * @property int $class_cod
 * @property int $status_cod
 * @property string $assunto
 * @property int $operador
 * @property Carbon $data_abertura
 * @property Carbon|null $data_conclusao
 * @property Carbon $cli_leitura
 * @property int $duracao
 * @property Carbon|null $previsao
 * @property int $rating
 * 
 * @property Cliente $cliente
 * @property StatusTicket $status_ticket
 * @property Setor $setor
 * @property Categorium $categorium
 * @property Collection|TicketAnexo[] $ticket_anexos
 * @property Collection|TicketPost[] $ticket_posts
 *
 * @package App\Models
 */
class Ticket extends Model
{
	protected $table = 'tickets';
	protected $primaryKey = 'id_ticket';
	public $timestamps = false;

	protected $casts = [
		'numero' => 'int',
		'scrum' => 'int',
		'cli_user' => 'int',
		'cli_cod' => 'int',
		'setor_cod' => 'int',
		'categoria_cod' => 'int',
		'class_cod' => 'int',
		'status_cod' => 'int',
		'operador' => 'int',
		'duracao' => 'int',
		'rating' => 'int'
	];

	protected $dates = [
		'data_abertura',
		'data_conclusao',
		'cli_leitura',
		'previsao'
	];

	protected $fillable = [
		'numero',
		'scrum',
		'cli_user',
		'cli_cod',
		'setor_cod',
		'categoria_cod',
		'class_cod',
		'status_cod',
		'assunto',
		'operador',
		'data_abertura',
		'data_conclusao',
		'cli_leitura',
		'duracao',
		'previsao',
		'rating'
	];

	public function cli_user()
	{
		return $this->belongsTo(CliUser::class, 'cli_user');
	}

	public function cliente()
	{
		return $this->belongsTo(Cliente::class, 'cli_cod');
	}

	public function status_ticket()
	{
		return $this->belongsTo(StatusTicket::class, 'status_cod');
	}

	public function setor()
	{
		return $this->belongsTo(Setor::class, 'setor_cod');
	}

	public function categorium()
	{
		return $this->belongsTo(Categorium::class, 'categoria_cod');
	}

	public function ticket_anexos()
	{
		return $this->hasMany(TicketAnexo::class, 'id_ticket');
	}

	public function ticket_posts()
	{
		return $this->hasMany(TicketPost::class, 'id_ticket');
	}
}
