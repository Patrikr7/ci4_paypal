<?php

// LIMPA CARACTER NO CPF E CNPJ
if (!function_exists('clean')) :
	/**
	 * @param $valor
	 * @return mixed|string
	 */
	function clean($valor)
	{
		$valor = trim($valor);
		$valor = str_replace(".", "", $valor);
		$valor = str_replace(",", "", $valor);
		$valor = str_replace("-", "", $valor);
		$valor = str_replace("/", "", $valor);
		return $valor;
	}
endif;

// VALIDA CPF
if (!function_exists('validateCPF')) :
	/**
	 * @param null $cpf
	 * @return bool
	 */
	function validateCPF($cpf = null)
	{
		// Extrai somente os números
		$cpf = preg_replace( '/[^0-9]/is', '', $cpf );

		// Verifica se foi informado todos os digitos corretamente
		if (strlen($cpf) != 11) {
			return false;
		}

		// Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
		if (preg_match('/(\d)\1{10}/', $cpf)) {
			return false;
		}

		// Faz o calculo para validar o CPF
		for ($t = 9; $t < 11; $t++) {
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf[$c] * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf[$c] != $d) {
				return false;
			}
		}
		return true;
	}
endif;

// valida cnpj
if (!function_exists('validateCNPJ')) :
	function validateCNPJ($cnpj)
	{
		if (empty($cnpj))
			return false;
		$j = 0;
		for ($i = 0; $i < (strlen($cnpj)); $i++) {
			if (is_numeric($cnpj[$i])) {
				$num[$j] = $cnpj[$i];
				$j++;
			}
		}
		if (count($num) != 14)
			return false;
		if ($num[0] == 0 && $num[1] == 0 && $num[2] == 0 && $num[3] == 0 && $num[4] == 0 && $num[5] == 0 && $num[6] == 0 && $num[7] == 0 && $num[8] == 0 && $num[9] == 0 && $num[10] == 0 && $num[11] == 0)
			$isCnpjValid = false;
		else {
			$j = 5;
			for ($i = 0; $i < 4; $i++) {
				$multiplica[$i] = $num[$i] * $j;
				$j--;
			}
			$soma = array_sum($multiplica);
			$j = 9;
			for ($i = 4; $i < 12; $i++) {
				$multiplica[$i] = $num[$i] * $j;
				$j--;
			}
			$soma = array_sum($multiplica);
			$resto = $soma % 11;
			if ($resto < 2)
				$dg = 0;
			else $dg = 11 - $resto;
			if ($dg != $num[12])
				$isCnpjValid = false;
		}

		if (!isset($isCnpjValid)) {
			$j = 6;
			for ($i = 0; $i < 5; $i++) {
				$multiplica[$i] = $num[$i] * $j;
				$j--;
			}
			$soma = array_sum($multiplica);
			$j = 9;
			for ($i = 5; $i < 13; $i++) {
				$multiplica[$i] = $num[$i] * $j;
				$j--;
			}
			$soma = array_sum($multiplica);
			$resto = $soma % 11;
			if ($resto < 2)
				$dg = 0;
			else $dg = 11 - $resto;
			if ($dg != $num[13])
				$isCnpjValid = false;
			else $isCnpjValid = true;
		}
		return $isCnpjValid;
	}
endif;

if (!function_exists('PagSeguroStatus')):
	/**
	 * @param $m
	 * @return string
	 */
	function PagSeguroStatus($id)
	{
		switch ($id) {
			case 1:
				$text = 'Aguardando Pagamento';
				break;
			case 2:
				$text = 'Em Análise';
				break;
			case 3:
				$text = 'Paga';
				break;
			case 4:
				$text = 'Disponível';
				break;
			case 5:
				$text = 'Em Disputa';
				break;
			case 6:
				$text = 'Devolvida';
				break;
			case 7:
				$text = 'Cancelado';
				break;
			default:
				$text = 'Erro ao detectar transação';
		}

		return $text;
	}
endif;

if (!function_exists('PagSeguroType')):
	/**
	 * @param $m
	 * @return string
	 */
	function PagSeguroType($id)
	{
		switch ($id) {
			case 1:
				$text = 'Cartão de crédito';
				break;
			case 2:
				$text = 'Boleto';
				break;
			case 3:
				$text = 'Débito online (TEF)';
				break;
			case 4:
				$text = 'Saldo PagSeguro';
				break;
			case 5:
				$text = 'Oi Paggo *';
				break;
			case 7:
				$text = 'Depósito em conta';
				break;
			default:
				$text = 'Erro ao detectar tipo de pagamento';
		}

		return $text;
	}
endif;
