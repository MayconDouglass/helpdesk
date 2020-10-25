<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StatusTicket
 * 
 * @property int $id_status
 * @property string $descricao
 * @property bool $status
 * 
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class StatusTicket extends Model
{
	protected $table = 'status_ticket';
	protected $primaryKey = 'id_status';
	public $timestamps = false;

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'descricao',
		'status'
	];

	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'status_cod');
	}
}
