
<div class="form-group row mb-1" data-val=<?= $value * 100 ?>>

    <label
        for="<?= $id = $type . '-' . sprintf('%06d', $value * 100) ?>"
        class="col-sm-4 col-form-label">
            <?= $label ?>
    </label>

    <div class="col-sm-4">
        <input
            type="number"
            name="<?= $type . '[' . sprintf('%06d', $value * 100) . ']' ?>"
            id="<?= $id ?>"
            class="form-control currency-count"
            min=0
            placeholder="0"
            dir="rtl">
    </div>

    <div class="col-sm-4 text-right currency-ext">
        $0.00
    </div>

</div>
