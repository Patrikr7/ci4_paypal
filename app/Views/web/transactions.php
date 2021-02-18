<div class="row">
    <div class="col-12">
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="mb-0">Transações</h4>
            </div>
            <div class="card-body">
				<?php if ($transactions): ?>
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Data</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
						<?php foreach ($transactions as $transaction): ?>
                            <tr>
                                <th><?php echo $transaction['id']; ?></th>
                                <td><?php echo date('d/m/Y', strtotime($transaction['created_at'])); ?></td>
                                <td>R$ <?php echo number_format($transaction['total'], 2, ',', '.'); ?></td>
                                <td><?php echo $transaction['status']; ?></td>
                            </tr>
						<?php endforeach; ?>
                        </tbody>
                    </table>
				<?php else: ?>
                    <div class="alert alert-dismissible alert-warning mb-0">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4 class="alert-heading">Informação!</h4>
                        <p class="mb-0">Nenhuma transação no momento.</p>
                    </div>
				<?php endif; ?>

            </div>
        </div>
    </div>
</div>