<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BuildDetail
 * 
 * @property int $id_details
 * @property int $id_ticket
 * @property int $user
 * @property int $id_build
 * @property bool $status
 * @property string $descricao
 * 
 * @property BuildList $build_list
 * @property Ticket $ticket
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class BuildDetail extends Model
{
	protected $table = 'build_details';
	protected $primaryKey = 'id_details';
	public $timestamps = false;

	protected $casts = [
		'id_ticket' => 'int',
		'user' => 'int',
		'id_build' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'id_ticket',
		'user',
		'id_build',
		'status',
		'descricao'
	];

	public function build_list()
	{
		return $this->belongsTo(BuildList::class, 'id_build');
	}

	public function ticket()
	{
		return $this->belongsTo(Ticket::class, 'id_ticket');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'user');
	}
}
