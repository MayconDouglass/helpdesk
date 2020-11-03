<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BuildList
 * 
 * @property int $id_build
 * @property bool $dialecto
 * @property int $build
 * @property int $tipo
 * @property string|null $observacao
 * @property bool $status
 * @property Carbon $data_cad
 * @property Carbon|null $data_alt
 * 
 * @property Collection|BuildDetail[] $build_details
 *
 * @package App\Models
 */
class BuildList extends Model
{
	protected $table = 'build_list';
	protected $primaryKey = 'id_build';
	public $timestamps = false;

	protected $casts = [
		'dialecto' => 'bool',
		'build' => 'int',
		'tipo' => 'int',
		'status' => 'bool'
	];

	protected $dates = [
		'data_cad',
		'data_alt'
	];

	protected $fillable = [
		'dialecto',
		'build',
		'tipo',
		'observacao',
		'status',
		'data_cad',
		'data_alt'
	];

	public function build_details()
	{
		return $this->hasMany(BuildDetail::class, 'id_build');
	}
}
