<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CargoAcesso
 * 
 * @property int $id_acesso
 * @property int $cargo_cod
 * @property int $role
 * @property bool $status
 * 
 * @property Cargo $cargo
 *
 * @package App\Models
 */
class CargoAcesso extends Model
{
	protected $table = 'cargo_acesso';
	protected $primaryKey = 'id_acesso';
	public $timestamps = false;

	protected $casts = [
		'cargo_cod' => 'int',
		'role' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'cargo_cod',
		'role',
		'status'
	];

	public function cargo()
	{
		return $this->belongsTo(Cargo::class, 'cargo_cod');
	}

	public function role()
	{
		return $this->belongsTo(Role::class, 'role');
	}
}
