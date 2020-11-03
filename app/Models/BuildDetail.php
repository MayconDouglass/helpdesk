<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
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
 * @property int $menu
 * @property int $modulo
 * @property Carbon|null $data_liberacao
 * 
 * @property BuildList $build_list
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
		'status' => 'bool',
		'menu' => 'int',
		'modulo' => 'int'
	];

	protected $dates = [
		'data_liberacao'
	];

	protected $fillable = [
		'id_ticket',
		'user',
		'id_build',
		'status',
		'descricao',
		'menu',
		'modulo',
		'data_liberacao'
	];

	public function build_list()
	{
		return $this->belongsTo(BuildList::class, 'id_build');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'user');
	}
}
