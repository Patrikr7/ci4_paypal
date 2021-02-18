<?php

namespace App\Controllers;

use App\Models\{
	ProductsModel, TransactionModel
};

class Home extends BaseController
{
	/**
	 * Acesso a página principal
	 * @return mixed
	 */
	public function index()
	{
		$dados = [
			'title'    => 'Início',
			'products' => (new ProductsModel())->findAll(),
		];

		return $this->template->load('web/template/template', 'web/home', $dados);
	}

	/**
	 * Acesso a página de carrinho
	 * @return mixed
	 */
	public function cart()
	{
		$dados = [
			'title'    => 'Carrinho',
			'products' => (new ProductsModel())->findAll(),
		];

		return $this->template->load('web/template/template', 'web/cart', $dados);
	}

	/**
	 * Faz o processamento e em seguida é redirecionado para
	 * a página de pagamento do PayPal
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function purchase()
	{
		$transactionsModel = new TransactionModel();
		$productsModel = new ProductsModel();

		$post = $this->request->getPost();

		if (isset($post['products']) && count($post['products']) > 0):
			$products = $productsModel->whereIn('id', $post['products'])->findAll();

			$total = 0;
			foreach ($products as $product):
				$total += $product['price'];
			endforeach;

			try {
				$transactionsModel->save(['total' => $total]);
				$idReference = $transactionsModel->insertID();
				session()->setFlashData('idReference', $idReference);

				$apiContext = new \PayPal\Rest\ApiContext(
					new \PayPal\Auth\OAuthTokenCredential(
						PAYPAL_CLIENT_ID, PAYPAL_SECRET
					)
				);

				$payer = new \PayPal\Api\Payer();
				$payer->setPaymentMethod('paypal');

				$amount = new \PayPal\Api\Amount();
				$amount->setCurrency('BRL')->setTotal($total);

				$transactionPay = new \PayPal\Api\Transaction();
				$transactionPay->setAmount($amount);
				$transactionPay->setInvoiceNumber($idReference);

				$redirectUrls = new \PayPal\Api\RedirectUrls();
				$redirectUrls->setReturnUrl(base_url('obrigado'));
				$redirectUrls->setCancelUrl(base_url('cancelado'));

				$payment = new \PayPal\Api\Payment();
				$payment->setIntent('sale');
				$payment->setPayer($payer);
				$payment->setTransactions([$transactionPay]);
				$payment->setRedirectUrls($redirectUrls);

				try {

					$payment->create($apiContext);

					header('Location: ' . $payment->getApprovalLink());
					exit;

				} catch (\PayPal\Exception\PayPalConnectionException $e) {
					$transactionsModel->delete($idReference);
					session()->setFlashData('msg', $e->getData());
					return redirect()->route('cart');
				}

			} catch (\Exception $e) {
				session()->setFlashData('msg', $e->getMessage());
				return redirect()->route('cart');

			}

		else:
			session()->setFlashData('msg', 'Nenhum produto selecionado!');
			return redirect()->route('cart');
		endif;
	}

	/**
	 * Página de obrigado
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function thanks()
	{
		$transactionsModel = new TransactionModel();

		$apiContext = new \PayPal\Rest\ApiContext(
			new \PayPal\Auth\OAuthTokenCredential(
				PAYPAL_CLIENT_ID, PAYPAL_SECRET
			)
		);

		$payment = \PayPal\Api\Payment::get($_GET['paymentId'], $apiContext);

		$execution = new \PayPal\Api\PaymentExecution();
		$execution->setPayerId($_GET['PayerID']);

		try{
			$result = $payment->execute($execution, $apiContext);

			try{
				$payment = \PayPal\Api\Payment::get($_GET['paymentId'], $apiContext);
				$status = $payment->getState();
				$t = current($payment->getTransactions());
				$t = $t->toArray();
				$ref = $t['invoice_number'];

				if($status == 'approved'):
					$transactionsModel->update($ref, ['status' => 'aprovado']);

					return $this->template->load('web/template/template', 'web/thanks', ['title' => 'Compra efetuada com sucesso!']);

				else:
					$transactionsModel->update($ref, ['status' => 'cancelado']);
					return redirect()->route('canceled');
					exit;
				endif;

			}catch (\Exception $e){
				$transactionsModel->update(session()->getFlashData('idReference'), ['status' => 'cancelado']);
				return redirect()->route('canceled');
			}

		}catch (\Exception $e){
			$transactionsModel->update(session()->getFlashData('idReference'), ['status' => 'cancelado']);
			return redirect()->route('canceled');
		}

	}

	/**
	 * Caso dê algum erro no processamento é
	 * redirecionado para a página de cancelado
	 * @return mixed
	 */
	public function canceled()
	{
		$dados = [
			'title'    => 'Compra cancelada',
		];

		return $this->template->load('web/template/template', 'web/canceled', $dados);
	}
}
