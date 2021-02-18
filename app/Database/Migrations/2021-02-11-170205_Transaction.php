<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaction extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'           => [
				'type'           => 'INT',
				'constraint'     => '11',
				'unsigned'       => true,
				'null'           => false,
				'auto_increment' => true,
			],
			'total'        => [
				'type'       => 'decimal',
				'constraint' => '11,2',
				'null'       => true,
			],
			'status'         => [
				'type'       => 'enum',
				'constraint' => ['em análise', 'aprovado', 'cancelado'],
				'default'    => 'em análise',
				'null'       => false,
				'comment'    => 'status da transação',
			],
			'created_at'              => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'updated_at'              => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);

		$this->forge->addPrimaryKey('id', true);
		$this->forge->addUniqueKey(['id'], true);

		$attributes = ['ENGINE' => 'InnoDB'];
		$this->forge->createTable('transactions', true, $attributes);
	}

	public function down()
	{
		$this->forge->dropTable('tb_transactions', true);
	}
}
