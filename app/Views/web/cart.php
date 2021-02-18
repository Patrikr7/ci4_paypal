<div class="row">
    <div class="col-12">
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="mb-0">Carrinho</h4>
            </div>
            <div class="card-body">
				<?php
				$message = session()->getFlashData('msg');
				if (!empty($message)) : ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
								<?php echo $message ?>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>

				<?php echo form_open('close-purchase', ['onsubmit' => 'document.getElementById("btn-submit").disable=true']); ?>

                <table class="table table-hover table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach ($products as $product): ?>
                        <tr>
                            <th><?php echo $product['id']; ?></th>
                            <td><?php echo $product['description']; ?></td>
                            <td><?php echo 'R$ ' . number_format($product['price'], 2, ',', '.'); ?></td>
                            <td><input type="checkbox" name="products[]" value="<?php echo $product['id']; ?>"/></td>
                        </tr>
					<?php endforeach; ?>
                    </tbody>
                </table>
                <div class="row no-gutters d-flex justify-content-end">
                    <button class="btn btn-success" type="submit" id="btn-submit" onclick='this.innerHTML="<i class=\"fa fa-spinner fa-spin fa-fw form_load\"></i> Aguarde..."'>
                        Efetuar Pagamento
                    </button>
                </div>

				<?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>