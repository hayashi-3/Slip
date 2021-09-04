@extends('layouts.app')
@push('js')
  <script src="{{ asset('js/changeEditForm.js') }}" defer></script>
  <script src="{{ asset('js/yearInactiveButton.js') }}" defer></script>
  <script src="{{ asset('js/inactiveButton.js') }}" defer></script>
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
   <h4>年次決算</h4>

   <!-- 年次決算書き出し -->
   <div class="row">
      <div class="col col-7"></div>
      <div class="col col-5">
        <form class="form-inline ml-4" method="POST" action="{{ route('y_summary.store') }}">
          @csrf
          <div class="input-group mr-4">
            <input type="number" name="year" min="2021" id="inp_year">
            <label for="inp_year">年度</label>
          </div>
          <input type="submit" class="btn btn-outline-danger ml-3 y_output" value="年次決算を出力する"
            data-toggle="tooltip" title="まだ年次決算は確定しません" data-placement="top" >
        </form>
      </div>
   </div>

   <!-- excelのエクスポート -->
   <div class="row">
      <div class="col col-7"></div>
      <div class="col col-5 mt-3">
         <form class="form-inline" method="GET" action="{{ route('export') }}">
            <div class="form-group ml-4 mr-5">
               <select name="display_year" class="form-select select" id="year">
                  <option hidden>選択してください</option>
                  @foreach($years as $y)
                  <option value="{{ $y->accountin_year }}">{{ $y->accountin_year }}</option>
                  @endforeach
               </select>
               <label for="year">年度</label>
            </div>
            <button class="btn btn-outline-success ml-3 excel_btn" data-toggle="tooltip" title="1年分の明細を出力します" data-placement="bottom">
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
            <form class="form-inline ml-4 data-edit" method="post" action="{{ route('y_summary.update') }}">
            @csrf
               <table class="table">
                  <thead>
                     <tr>
                        <th scope="col">科目</th>
                        <th scope="col">小計</th>
                        <th scope="col">消費税</th>
                        <th scope="col">総計</th>
                        <th scope="col">編集</th>
                        <th scope="col">保存</th>
                        <th scope="col">キャンセル</th>
                     </tr>
                  </thead>
                  <!-- 年次確定 -->
                  <tbody>
                     @foreach ($y_summary as $ys)
                        @if ($y->accountin_year === $ys->accountin_year)
                           <tr class="data-edit">
                              <!-- 表示・編集用 -->
                              <td class="subject_name_value">{{ $ys->subject_name }}</td>
                              <td class="subject_name_change">
                                 <input type="text" name="subject_name" value="{{ $ys->subject_name }}" readonly><br>
                                 <span class="comment">*この項目は編集できません</span>
                              </td>
                              <td class="subtotal_value">¥{{ number_format($ys->year_subtotal) }}</td>
                              <td class="subtotal_change"><input type="number" name="u_year_subtotal" value="{{ $ys->year_subtotal }}"></td>
                              <td class="sales_tax_value">¥{{ number_format($ys->year_sales_tax) }}</td>
                              <td class="sales_tax_change"><input type="number" name="u_year_sales_tax" value="{{ $ys->year_sales_tax }}"></td>
                              <td class="grand_total_value">¥{{ number_format($ys->year_grand_total) }}</td>
                              <td class="grand_total_change"><input type="number" name="u_year_grand_total" value="{{ $ys->year_grand_total }}"></td>
                              <input type="hidden" name="u_id" value="{{ $ys->id }}">
                              <input type="hidden" name="u_subject_id" value="{{ $ys->subject_id }}">
                              <input type="hidden" name="u_accountin_year" value="{{ $ys->accountin_year }}">
                              @if ($ys->confirm != 2)
                                 <td><input type="button" value="編集" class="edit-line"></td>
                                 <td><input type="submit" name="update" value="保存" class="save-line"></td>
                                 <td><input type="button" value="×" class="cancel-line"></td>
                              @endif
                              <!-- 更新用 confirmはcontrollerで値をいれる -->
                              <input type="hidden" name="id" value="{{ $ys->id }}">
                              <input type="hidden" name="subject_id" value="{{ $ys->subject_id }}">
                              <input type="hidden" name="accountin_year" value="{{ $ys->accountin_year }}">
                              <input type="hidden" name="year_subtotal" value="{{ $ys->year_subtotal }}">
                              <input type="hidden" name="year_sales_tax" value="{{ $ys->year_sales_tax }}">
                              <input type="hidden" name="year_grand_total" value="{{ $ys->year_grand_total }}">
                              @if ($ys->confirm != 2)
                                 <button type="submit" name="confirm" class="btn btn-danger mb-3">年次決算を確定する</button>
                              @endif
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