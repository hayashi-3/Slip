<form class="form-inline ml-4" method="post" action="{{ route('m_summary.update') }}">
  @csrf
  <div class="id_value">{{ $ms_slip->id }}</div>
  <div class="id_change"><input type="text" name="id" value="{{ $ms_slip->id }}"></div>
  @if ($ms_slip->is_cash === 0)
    <div class="is_cash_value">現金</div>
  @else
    <div class="is_cash_value">クレジット</div>
  @endif
  <div class="is_cash_change">
    <input type="hidden" name="is_cash" id="is_cash" value="0">
    <input type="checkbox" name="is_cash" class="form-check-input" id="is_cash" value="1" @if ($ms_slip->is_cash == 1) checked @endif>クレジット
  </div>
  <div class="subject_name_value">{{ $ms_slip->subject_name }}</div>
  <div class="subject_name_change">
      <select name="subject_id" id="subject">
        @foreach($subject as $sb)
          @if($ms_slip->subject_id === $sb->id)
            <option value="{{ $sb->id }}" selected>{{ $sb->subject_name }}</option>
          @else
            <option value="{{ $sb->id }}">{{ $sb->subject_name }}</option>
          @endif
        @endforeach
      </select>
  </div>
  <div class="accrual_year_value">{{ $ms_slip->accrual_year }}/{{ $ms_slip->accrual_month }}/{{ $ms_slip->accrual_date }}</div>
  <div class="accrual_year_change"><input type="text" class="ajast" name="accrual_year" value="{{ $ms_slip->accrual_year }}/{{ $ms_slip->accrual_month }}/{{ $ms_slip->accrual_date }}"></div>
  <!-- マイナスは赤字にする -->
  @if ($ms_slip->price > 0)
    <div class="price_value">¥{{ number_format($ms_slip->price) }}</div>
    <div class="price_change"><input type="number" class="ajast" name="price" value="{{ $ms_slip->price }}"></div>
  @else
    <div class="canceled price_value">¥{{ number_format($ms_slip->price) }}</div>
    <div class="canceled price_change"><input type="number" class="ajast" value="{{ $ms_slip->price }}"></div>
  @endif
  @if ($ms_slip->subtotal > 0)
    <div class="subtotal_value">¥{{ number_format($ms_slip->subtotal) }}</div>
    <div class="subtotal_change"><input type="number" class="ajast" name="subtotal" value="{{ $ms_slip->subtotal }}"></div>
  @else
    <div class="canceled subtotal_value">¥{{ number_format($ms_slip->subtotal) }}</div>
    <div class="canceled subtotal_change"><input type="number" class="ajast" name="subtotal" value="{{ $ms_slip->subtotal }}"></div>
  @endif
    <div class="sales_tax_rate_value">{{ $ms_slip->sales_tax_rate }}%</div>
    <div class="sales_tax_rate_change"><input type="number" class="ajast" name="sales_tax_rate" value="{{ $ms_slip->sales_tax_rate }}">%</div>
  @if ($ms_slip->sales_tax > 0)
    <div class="sales_tax_value">¥{{ number_format($ms_slip->sales_tax) }}</div>
    <div class="sales_tax_change"><input type="number" class="ajast" name="sales_tax" value="{{ $ms_slip->sales_tax }}"></div>
  @else
    <div class="canceled sales_tax_value">¥{{ number_format($ms_slip->sales_tax) }}</div>
    <div class="canceled sales_tax_change"><input type="number" class="ajast" name="sales_tax" value="{{ $ms_slip->sales_tax }}"></div>
  @endif
  @if ($ms_slip->grand_total > 0)
    <div class="grand_total_value">¥{{ number_format($ms_slip->grand_total) }}</div>
    <div class="grand_total_change"><input type="number" class="ajast" name="grand_total" value="{{ $ms_slip->grand_total }}"></div>
  @else
    <div class="canceled grand_total_value">¥{{ number_format($ms_slip->grand_total) }}</div>
    <div class="canceled grand_total_change"><input type="number" class="ajast" name="grand_total" value="{{ $ms_slip->grand_total }}"></div>
  @endif
    <div class="remarks_value">{{ $ms_slip->remarks }}</div>
    <div class="remarks_change"><input type="text" class="ajast" name="remarks" value="{{ $ms_slip->remarks }}"></div>
  @if ($ms_slip->annual_confirmation === 0)
    <div class="ajast_div"><input type="button" value="編集" class="btn btn-info btn-sm edit-line"></div>
    <div class="ajast_div"><input type="submit" value="保存" class="btn btn-info btn-sm save-line"></div>
    <div class="ajast_div"><input type="button" value="×" class="btn btn-secondary btn-sm cancel-line"></div>
    <div class="ajast_div"><input type="button" class="btn btn-outline-danger btn-sm" value="削除"></div>
  @endif
</form>