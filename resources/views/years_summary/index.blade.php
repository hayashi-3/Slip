@extends('layouts.app')

@section('content')
<div class="container">
   <h4>年次決算</h4>

   <!-- 年次決算書き出し -->
   <div class="row">
      <div class="col col-7"></div>
      <div class="col col-5">
        <form class="form-inline ml-4" method="POST" action="{{ route('y_summary.store') }}">
          @csrf
          <div class="input-group mr-4">
            <input type="number" name="year" min="2021" id="year">
            <label for="year">年度</label>
          </div>
          <input type="submit" class="btn btn-outline-danger" value="年次決算を出力する" data-toggle="tooltip" title="まだ年次決算は確定しません" data-placement="top">
        </form>
      </div>
   </div>

   <!-- excelのエクスポート -->
   <div class="row">
      <div class="col col-7"></div>
      <div class="col col-5 mt-3">
         <form class="form-inline" method="GET" action="{{ route('export') }}">
            <div class="form-group ml-4 mr-5">
               <select name="display_year" class="form-select" id="year">
                  <option hidden>選択してください</option>
                  @foreach($years as $y)
                  <option value="{{ $y->accountin_year }}">{{ $y->accountin_year }}</option>
                  @endforeach
               </select>
               <label for="year">年度</label>
            </div>
            <button class="btn btn-outline-success ml-3" data-toggle="tooltip" title="1年分の明細を出力します" data-placement="bottom">
               Excel出力
            </button>
         </form>
      </div>
   </div>

   <ul class="tab-menu">
      @foreach ($years as $y)
         <li class="tab-menu__item"><span class="tab-trigger js-tab-trigger" data-id="{{ $y->accountin_year }}">{{ $y->accountin_year }}年</span></li>
      @endforeach
   </ul><!-- .tab-menu -->

   <div class="tab-content">
      @foreach ($years as $y)
         <div class="tab-content__item js-tab-target" id="{{ $y->accountin_year }}">
            <form class="form-inline ml-4" method="POST" action="{{ route('y_summary.update') }}">
            @csrf
               <table class="table">
                  <thead>
                     <tr>
                        <th scope="col">科目</th>
                        <th scope="col">小計</th>
                        <th scope="col">消費税</th>
                        <th scope="col">総計</th>
                     </tr>
                  </thead> 
                  <!-- 年次確定 -->
                  <tbody>
                     @foreach ($y_summary as $ys)
                        @if ($y->accountin_year === $ys->accountin_year)
                           <tr>
                              <!-- 表示用 -->
                              <td>{{ $ys->subject_name }}</td>
                              <td>¥{{ number_format($ys->year_subtotal) }}</td>
                              <td>¥{{ number_format($ys->year_sales_tax) }}</td>
                              <td>¥{{ number_format($ys->year_grand_total) }}</td>
                              <!-- 更新用 confirmはcontrollerで値をいれる -->
                              <input type="hidden" name="id" value="{{ $ys->id }}">
                              <input type="hidden" name="subject_id" value="{{ $ys->subject_id }}">
                              <input type="hidden" name="accountin_year" value="{{ $ys->accountin_year }}">
                              <input type="hidden" name="year_subtotal" value="{{ $ys->year_subtotal }}">
                              <input type="hidden" name="year_sales_tax" value="{{ $ys->year_sales_tax }}">
                              <input type="hidden" name="year_grand_total" value="{{ $ys->year_grand_total }}">
                              <button type="submit" class="btn btn-danger mb-3">年次決算を確定する</button>
                           </tr>
                        @endif
                     @endforeach
                  </tbody>
               </table>
            </form>
         </div><!-- .tab-content__item -->
      @endforeach
   </div><!-- .tab-content -->
</div>

<script>
   document.addEventListener("DOMContentLoaded", () => {
      $(function () {
         $('[data-toggle="tooltip"]').tooltip()
      })
   });
</script>
@endsection