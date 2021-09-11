@extends('layouts.app')
@push('js')
  <script src="{{ asset('js/changeEditForm.js') }}" defer></script>
@endpush

@section('content')
<!-- フラッシュメッセージ -->
@if (session('flash_message'))
  <div class="alert alert-success">
      {{ session('flash_message') }}
  </div>
@endif

<!-- エラーメッセージ -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
  <h4>月間詳細</h4>
  <form class="form-inline ml-4 data-edit" method="post" action="{{ route('m_summary.update') }}">
  @csrf
  <table class="table">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">支払方法</th>
        <th scope="col">科目名</th>
        <th scope="col">発生日</th>
        <th scope="col">金額</th>
        <th scope="col">小計</th>
        <th scope="col">消費税率</th>
        <th scope="col">消費税額</th>
        <th scope="col">総計</th>
        <th scope="col">備考</th>
        <th scope="col">編集</th>
        <th scope="col">削除</th>
        <th scope="col">キャンセル</th>
      </tr>
    </thead>
    <tbody>
      @foreach($m_summary_slip as $ms_slip)
        <tr class="data-edit">
          <td class="id_value"></td>
          <td class="id_change"><input type="hidden" name="id" value="{{ $ms_slip->id }}"></td>
          @if ($ms_slip->is_cash === 0)
            <td class="is_cash_value">現金</td>
          @else
            <td class="is_cash_value">クレジット</td>
          @endif
          <td class="is_cash_value"><input type="hidden" name="is_cash" class="form-check-input" id="is_cash" value="0"></td>
          <td class="is_cash_change"><input type="checkbox" name="is_cash" class="form-check-input" id="is_cash" value="1" @if ($ms_slip->is_cash == 1) checked @endif>クレジット</td>
          <td class="subject_name_value">{{ $ms_slip->subject_name }}</td>
          <td class="subject_name_change"><input type="text" name="subject_name" value="{{ $ms_slip->subject_name }}"></td>
          <td class="accrual_year_value">{{ $ms_slip->accrual_year }}/{{ $ms_slip->accrual_month }}/{{ $ms_slip->accrual_date }}</td>
          <td class="accrual_year_change"><input type="text" value="{{ $ms_slip->accrual_year }}/{{ $ms_slip->accrual_month }}/{{ $ms_slip->accrual_date }}"></td>
          <!-- マイナスは赤字にする -->
          @if ($ms_slip->price > 0)
            <td class="price_value">¥{{ number_format($ms_slip->price) }}</td>
            <td class="price_change"><input type="number" value="{{ $ms_slip->price }}"></td>
          @else
            <td class="canceled price_value">¥{{ number_format($ms_slip->price) }}</td>
            <td class="canceled price_change"><input type="number" value="{{ $ms_slip->price }}"></td>
          @endif
          @if ($ms_slip->subtotal > 0)
            <td class="subtotal_value">¥{{ number_format($ms_slip->subtotal) }}</td>
            <td class="subtotal_change"><input type="number" value="{{ $ms_slip->subtotal }}"></td>
          @else
            <td class="canceled subtotal_value">¥{{ number_format($ms_slip->subtotal) }}</td>
            <td class="canceled subtotal_change"><input type="number" value="{{ $ms_slip->subtotal }}"></td>
          @endif
          <td class="sales_tax_rate_value">{{ $ms_slip->sales_tax_rate }}%</td>
          <td class="sales_tax_rate_change"><input type="number" value="{{ $ms_slip->sales_tax_rate }}">%</td>
          @if ($ms_slip->sales_tax > 0)
            <td class="sales_tax_value">¥{{ number_format($ms_slip->sales_tax) }}</td>
            <td class="sales_tax_change"><input type="number" value="{{ $ms_slip->sales_tax }}"></td>
          @else
            <td class="canceled sales_tax_value">¥{{ number_format($ms_slip->sales_tax) }}</td>
            <td class="canceled sales_tax_change"><input type="number" value="{{ $ms_slip->sales_tax }}"></td>
          @endif
          @if ($ms_slip->grand_total > 0)
            <td class="grand_total_value">¥{{ number_format($ms_slip->grand_total) }}</td>
            <td class="grand_total_change"><input type="number" value="{{ $ms_slip->grand_total }}"></td>
          @else
            <td class="canceled grand_total_value">¥{{ number_format($ms_slip->grand_total) }}</td>
            <td class="canceled grand_total_change"><input type="number" value="{{ $ms_slip->grand_total }}"></td>
          @endif                
          <td class="remarks_value">{{ $ms_slip->remarks }}</td>
          <td class="remarks_change"><input type="text" value="{{ $ms_slip->remarks }}"></td>
          @if ($ms_slip->annual_confirmation === 0)
            <td><input type="button" value="編集" class="edit-line"></td>
            <td><input type="submit" name="update" value="保存" class="save-line"></td>
            <td><input type="button" value="×" class="cancel-line"></td>
          @endif
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection