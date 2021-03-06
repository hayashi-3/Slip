<!-- モーダル・伝票登録フォーム -->
<div class="modal fade edit{{ $sl->id }}" tabindex="-1" role="dialog" aria-labelledby="#editModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal">伝票編集</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('slip.update') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $sl->id }}">
                    <div class="form-check">
                        <input type="hidden" name="is_cash" class="form-check-input" id="is_cash" value="0">
                        <input type="checkbox" name="is_cash" class="form-check-input" id="is_cash" value="1" @if ($sl->is_cash == 1) checked @endif>
                        <label class="form-check-label" for="is_cash">クレジット</label>
                    </div>
                    <div class="form-group">
                        <label for="subject">科目</label>
                        <select name="subject_id" class="form-control" id="subject">
                            @foreach($subject as $sb)
                            <option value="{{ $sb->id }}">{{ $sb->subject_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">年</label>
                        <input type="number" name="accrual_year" class="form-control" id="year" value="{{ $sl->accrual_year }}" required>
                    </div>
                    <div class="form-group">
                        <label for="month">月</label>
                        <input type="number" name="accrual_month" class="form-control" id="month" value="{{ $sl->accrual_month }}" min="1" max="12" required>
                    </div>
                    <div class="form-group">
                        <label for="date">日</label>
                        <input type="number" name="accrual_date" class="form-control" id="date" value="{{ $sl->accrual_date }}" min="1" max="31" required>
                    </div>
                    <div class="form-group">
                        <label for="price">単価</label>
                        <input type="number" name="price" class="form-control" id="price" value="{{ $sl->price }}" required>
                    </div>
                    <div class="form-group">
                        <label for="sb">本体金額</label>
                        <input type="number" name="subtotal" class="form-control" id="sb" value="{{ $sl->subtotal }}" required>
                    </div>
                    <div class="form-group">
                        <label for="st_rate">消費税率(%)</label>
                        <input type="number" name="sales_tax_rate" class="form-control" id="st_rate" value="{{ $sl->sales_tax_rate }}" required>
                    </div>
                    <div class="form-group">
                        <label for="s_tax">消費税金額</label>
                        <input type="number" name="sales_tax" class="form-control" id="s_tax" value="{{ $sl->sales_tax }}" required>
                    </div>
                    <div class="form-group">
                        <label for="g_total">総計金額</label>
                        <input type="number" name="grand_total" class="form-control" id="g_total" value="{{ $sl->grand_total }}" required>
                    </div>
                    <div class="form-group">
                        <label for="rmark">備考</label>
                        <input type="text" name="remarks" class="form-control rmark" value="{{ $sl->remarks }}">
                    </div>
                    <button type="submit" name="s_update" class="btn btn-primary btn-lg btn-block">更新する</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>