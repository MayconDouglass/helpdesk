<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TicketPost
 * 
 * @property int $id_post
 * @property int $id_ticket
 * @property string $mensagem
 * @property int|null $cli_user
 * @property int|null $operador
 * @property int $origem
 * @property Carbon $data_cad
 * @property bool $visivel
 * 
 * @property Ticket $ticket
 * @property Usuario|null $usuario
 *
 * @package App\Models
 */
class TicketPost extends Model
{
	protected $table = 'ticket_post';
	protected $primaryKey = 'id_post';
	public $timestamps = false;

	protected $casts = [
		'id_ticket' => 'int',
		'cli_user' => 'int',
		'operador' => 'int',
		'origem' => 'int',
		'visivel' => 'bool'
	];

	protected $dates = [
		'data_cad'
	];

	protected $fillable = [
		'id_ticket',
		'mensagem',
		'cli_user',
		'operador',
		'origem',
		'data_cad',
		'visivel'
	];

	public function ticket()
	{
		return $this->belongsTo(Ticket::class, 'id_ticket');
	}

	public function cli_user()
	{
		return $this->belongsTo(CliUser::class, 'cli_user');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'operador');
	}
}
