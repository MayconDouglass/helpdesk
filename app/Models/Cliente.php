<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 * 
 * @property int $id_cliente
 * @property string $razao_social
 * @property string|null $nome_fantasia
 * @property string|null $contato
 * @property string|null $observacao
 * @property string|null $logradouro
 * @property string|null $cidade
 * @property string|null $bairro
 * @property string|null $uf
 * @property string|null $numero
 * @property string|null $complemento
 * @property bool $status
 * @property string $cli_cgc
 * @property string|null $cli_ie
 * @property Carbon $data_cad
 * @property Carbon|null $data_alt
 * 
 * @property Collection|CliUser[] $cli_users
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class Cliente extends Model
{
	protected $table = 'clientes';
	protected $primaryKey = 'id_cliente';
	public $timestamps = false;

	protected $casts = [
		'status' => 'bool'
	];

	protected $dates = [
		'data_cad',
		'data_alt'
	];

	protected $fillable = [
		'razao_social',
		'nome_fantasia',
		'contato',
		'observacao',
		'logradouro',
		'cidade',
		'bairro',
		'uf',
		'numero',
		'complemento',
		'status',
		'cli_cgc',
		'cli_ie',
		'data_cad',
		'data_alt'
	];

	public function cli_users()
	{
		return $this->hasMany(CliUser::class, 'cli_cod');
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'cli_cod');
	}
}
