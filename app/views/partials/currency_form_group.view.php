
<div class="form-group row mb-1" data-val=<?= $denomination->worth() ?>>

    <label
        for="<?= $id = $type . '-' . sprintf('%06d', $denomination->worth()) ?>"
        class="col-sm-4 col-form-label">
            <?= $denomination->name() ?>
    </label>

    <div class="col-8 col-sm-4">
        <input
            type="number"
            name="<?= $type . '[' . sprintf('%06d', $denomination->worth()) . ']' ?>"
            id="<?= $id ?>"
            class="form-control currency-count"
            min=0
            placeholder="0"
            dir="rtl">
    </div>

    <div class="col-4 col-sm-4 text-right currency-ext">
        $0.00
    </div>

</div>
