<!-- モーダルボタン -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
  伝票登録
  </button>
</div>

<!-- モーダル・伝票登録フォーム -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">伝票登録</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="{{ route('slip.store') }}">
            @csrf
            <div class="form-check">
              <input type="hidden" name="is_cash" class="form-check-input" id="is_cash" value="0">
              <input type="checkbox" name="is_cash" class="form-check-input" id="is_cash" value="1" checked>
              <label class="form-check-label" for="is_cash">クレジット</label>
            </div>
            <div class="form-group">
                <label for="subject">科目</label>
                <select name="subject_id" class="form-control" id="subject" onChange="changePulldown();">
                  <option hidden>選択してください</option>
                  @foreach($subject as $sb)
                    <option value="{{ $sb->id }}">{{ $sb->subject_name }}</option>
                  @endforeach
                </select>
                <label for="calculation">計算</label>
                <select name="calculation" class="form-control" id="cal">
                  @foreach($subject as $sb)
                    <span><option value="{{ $sb->calculation }}" data-id="{{ $sb->id }}">{{ $sb->calculation }}</option></span>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="year">年</label>
                <input type="number" name="accrual_year" class="form-control" id="year">
            </div>
            <div class="form-group">
                <label for="month">月</label>
                <input type="number" name="accrual_month" class="form-control" id="month">
            </div>
            <div class="form-group">
                <label for="date">日</label>
                <input type="number" name="accrual_date" class="form-control" id="date">
            </div>
            <div class="form-group">
                <label for="price">単価</label>
                <input type="number" name="price" class="form-control" id="price">
            </div>
            <div class="form-group">
              <label for="sb">本体金額</label>
              <input type="number" name="subtotal" class="form-control" id="sb">
            </div>
            <div class="form-group">
                <label for="st_rate">消費税率(%)</label>
                <input type="number" name="sales_tax_rate" class="form-control" id="st_rate">
                <input type="button" class="calc-btn" onclick="calc(subtotal.value, sales_tax_rate.value);" value="計算する">
            </div>
            <div class="form-group">
                <label for="s_tax">消費税金額</label>
                <input type="number" name="sales_tax" class="form-control" id="s_tax">
            </div>
            <div class="form-group">
                <label for="g_total">総計金額</label>
                <input type="number" name="grand_total" class="form-control" id="g_total">
            </div>
            <div class="form-group">
                <label for="remarks">備考</label>
                <input type="text" name="remarks" class="form-control" id="remarks">
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">登録する</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
        </div>
      </div>
  </div>
</div>