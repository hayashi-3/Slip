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
         @foreach ($m_summary as $m_s)
            @if ($m_s->month == $y_m)
               <p>{{ $m_s->subject_name }}：¥{{ number_format($m_s->sum) }}</p>
               <hr>
            @endif
         @endforeach
         </div><!-- .tab-content__item -->
      @endforeach

   <div class="mt-5">
      <canvas id="pieChart"></canvas>
      <script type="text/javascript">
        var json_slip = <?php
            $json_slip = json_encode($group_slip);
            echo $json_slip; ?>;

         var subject_names = [];
         for (var i = 0; i < json_slip.length; i++) {
            subject_names.push(json_slip[i].subject_name);
         }

         var subtotal = [];
         for (var i = 0; i < json_slip.length; i++) {
            subtotal.push(json_slip[i].sum);
         }
      </script>
   </div>
</div>
</div><!-- .tab-content -->

@endsection
