<?php

namespace App\Controllers;

use App\Models\TransactionModel;

class Transactions extends BaseController
{
	/**
	 * Página com todas transações
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function index()
	{
		$dados = [
			'title' => 'Transações',
			'transactions'  => (new TransactionModel())->findAll(),
		];

		return $this->template->load('web/template/template', 'web/transactions', $dados);
	}
}
