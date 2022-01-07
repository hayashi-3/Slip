@extends('layouts.app')

@section('content')
<div class="container">
   <h4>月次仕訳</h4>
   <h6 class="mb-3">*各タブをクリックすると科目毎の税込金額を確認できます</h6>

   <ul class="tab-menu">
      @foreach ($y_month as $y_m)
      <li class="tab-menu__item"><span class="tab-trigger js-tab-trigger" data-id="{{ $y_m }}">{{ $y_m }}月</span></li>
      @endforeach
   </ul><!-- .tab-menu -->

   <div class="tab-content">
      @foreach ($y_month as $y_m)
      <div class="tab-content__item js-tab-target" id="{{ $y_m }}">
         <table class="table">
            @foreach ($m_summary as $m_s)
            @if ($m_s->month === $y_m)
            <tr>
               <td>{{ $m_s->subject_name }}：¥{{ number_format($m_s->sum) }}
                  <a href="m_summary/{{ $m_s->year }}/{{ $m_s->month }}/{{ $m_s->subject_name }}">詳細</a>
               </td>
            </tr>
            @endif
            @endforeach
         </table>
      </div><!-- .tab-content__item -->
      @endforeach
   </div><!-- .tab-content -->
</div>
@endsection