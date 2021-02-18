<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
	protected $table            = 'tb_transactions';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $protectFields    = true;
	protected $allowedFields    = ['id', 'total', 'status'];
	protected $useTimestamps    = true;
	protected $createdField     = 'created_at';
	protected $updatedField     = 'updated_at';
}
