@extends('layouts.app')

@section('content')
<div class="container">
  <h4>月間詳細</h4>
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
      </tr>
    </thead>
    <tbody>
      @foreach($m_summary_slip as $ms_slip)
        <tr>
          <th scope="row">{{ $ms_slip->id }}</th>
          @if ($ms_slip->is_cash === 0)
          <td>現金</td>
          @else
          <td>クレジット</td>
          @endif

                <td>{{ $ms_slip->subject_name }}</td>

          <td>{{ $ms_slip->accrual_year }}/{{ $ms_slip->accrual_month }}/{{ $ms_slip->accrual_date }}</td>
          <!-- マイナスは赤字にする -->
          @if ($ms_slip->price > 0)
            <td>¥{{ number_format($ms_slip->price) }}</td>
          @else
            <td class="canceled">¥{{ number_format($ms_slip->price) }}</td>
          @endif
          @if ($ms_slip->subtotal > 0)
            <td>¥{{ number_format($ms_slip->subtotal) }}</td>
          @else
            <td class="canceled">¥{{ number_format($ms_slip->subtotal) }}</td>
          @endif
          <td>{{ $ms_slip->sales_tax_rate }}%</td>
          @if ($ms_slip->sales_tax > 0)
            <td>¥{{ number_format($ms_slip->sales_tax) }}</td>
          @else
            <td class="canceled">¥{{ number_format($ms_slip->sales_tax) }}</td>
          @endif
          @if ($ms_slip->grand_total > 0)
            <td>¥{{ number_format($ms_slip->grand_total) }}</td>
          @else
            <td class="canceled">¥{{ number_format($ms_slip->grand_total) }}</td>
          @endif                
          <td>{{ $ms_slip->remarks }}</td>
        @endforeach
      </tr>
    </tbody>
  </table>
</div>
@endsection