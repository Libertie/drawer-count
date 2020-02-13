<?php
$currency_index = $currency->getDenominations(true);

?>
<div id="history-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Drawer Count History</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="accordion" id="accordion">
                <?php foreach ($drawers as $drawer) : ?>
                <div class="card">
                    <div class="card-header" id="heading-<?= $drawer['id'] ?>">
                        <h2 class="mb-0">
                            <a class="btn btn-link"
                                data-toggle="collapse"
                                data-target="#collapse-<?= $drawer['id'] ?>"
                                aria-controls="collapse-<?= $drawer['id'] ?>">
                                    #<?= sprintf('%04d', $drawer['id']) ?>
                                    &ndash;
                                    <?= date('D, F jS, Y \a\t g:ia', strtotime($drawer['created'])) ?>
                            </a>
                        </h2>
                    </div>

                    <div id="collapse-<?= $drawer['id'] ?>"
                        class="collapse"
                        aria-labelledby="heading-<?= $drawer['id'] ?>"
                        data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    Total: <?= $currency->format($drawer['total']) ?> 
                                    <?php if ($drawer['expected']) : ?>
                                    <br>Expected: <?= $currency->format($drawer['expected']) ?>
                                    <br>Discrepancy: 
                                    <?= $currency->format($drawer['discrepancy']) ?>
                                    <?php endif; ?>
                                </p>
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Denomination</th>
                                            <th class="text-center">Qty.</th>
                                            <th class="text-right">Ext.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (json_decode($drawer['details'], true) as $type => $denominations) : ?>
                                        <?php if (array_sum($denominations)) : ?>
                                        <tr><td colspan="3" class="text-muted text-uppercase pt-3">
                                            <small><?= ucwords($type) ?></small>
                                        </td></tr>
                                        <?php foreach ($denominations as $denomination => $qty) : ?>
                                            <tr>
                                                <td><?= $currency_index[$type][$denomination] ?? 'Unknown' ?></td>
                                                <td class="text-center"><?= $qty ?: '0' ?></td>
                                                <td class="text-right">
                                                    <?= $currency->format(($qty ? ($qty * $denomination / 100) : 0)) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?= !count($drawers) ? '<div class="modal-body">There are no previously recorded counts.</div>' : '' ?> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>