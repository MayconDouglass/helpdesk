<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setor
 * 
 * @property int $id_setor
 * @property string $descricao
 * @property bool $status
 * 
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class Setor extends Model
{
	protected $table = 'setor';
	protected $primaryKey = 'id_setor';
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
		return $this->hasMany(Ticket::class, 'setor_cod');
	}
}
