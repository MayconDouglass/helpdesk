<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Classificacao
 * 
 * @property int $id_class
 * @property string $descricao
 * @property bool $status
 *
 * @package App\Models
 */
class Classificacao extends Model
{
	protected $table = 'classificacao';
	protected $primaryKey = 'id_class';
	public $timestamps = false;

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'descricao',
		'status'
	];
}
