<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cargo
 * 
 * @property int $id_cargo
 * @property string $descricao
 * @property bool $status
 * @property Carbon $data_cad
 * @property Carbon|null $data_alt
 * 
 * @property Collection|CargoAcesso[] $cargo_acessos
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Cargo extends Model
{
	protected $table = 'cargo';
	protected $primaryKey = 'id_cargo';
	public $timestamps = false;

	protected $casts = [
		'status' => 'bool'
	];

	protected $dates = [
		'data_cad',
		'data_alt'
	];

	protected $fillable = [
		'descricao',
		'status',
		'data_cad',
		'data_alt'
	];

	public function cargo_acessos()
	{
		return $this->hasMany(CargoAcesso::class, 'cargo_cod');
	}

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'cargo_cod');
	}
}
