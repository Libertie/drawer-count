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
                                <?= $drawer['total'] ?><br />
                                <?= $drawer['details'] ?>
                            </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?= ! count($drawers) ? '<div class="modal-body">There are no previously recorded counts.</div>' : '' ?> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>