<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TicketAnexo
 * 
 * @property int $id_anexo
 * @property int $id_ticket
 * @property int $origem
 * @property int|null $cli_user
 * @property int|null $operador
 * @property string $file
 * @property Carbon $data_cad
 * @property bool $visivel
 * 
 * @property Ticket $ticket
 * @property Usuario|null $usuario
 *
 * @package App\Models
 */
class TicketAnexo extends Model
{
	protected $table = 'ticket_anexos';
	protected $primaryKey = 'id_anexo';
	public $timestamps = false;

	protected $casts = [
		'id_ticket' => 'int',
		'origem' => 'int',
		'cli_user' => 'int',
		'operador' => 'int',
		'visivel' => 'bool'
	];

	protected $dates = [
		'data_cad'
	];

	protected $fillable = [
		'id_ticket',
		'origem',
		'cli_user',
		'operador',
		'file',
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
