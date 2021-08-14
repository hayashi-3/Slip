@extends('layouts.app')

@section('content')
<div class="container">
   <h4>年次決算</h4>

   <!-- excelのエクスポート -->
   <div class="row">
      <div class="col col-7"></div>
      <div class="col col-5">
        <form>
          <div>
            <input type="number" name="year">年度
            <input type="submit" value="年次決算を確定する">
          </div>
        </form>
        <a href="{{ route('export') }}">
           <button class="btn btn-success mr-3" data-toggle="tooltip" title="1年分の明細を出力します" data-placement="top">
             Excel出力
           </button>
        </a>
      </div>
   </div>

   <ul class="tab-menu">
      @foreach ($y_summary as $ys)
         <li class="tab-menu__item"><span class="tab-trigger js-tab-trigger" data-id="{{ $ys->id }}">{{ $ys->accountin_year }}</span></li>
      @endforeach
   </ul><!-- .tab-menu -->

   <div class="tab-content">
      @foreach ($y_summary as $ys)
      <div class="tab-content__item js-tab-target" id="{{ $ys->id }}">
         <table class="table">
            <thead>
               <tr>
                  <th scope="col">科目</th>
                  <th scope="col">小計</th>
                  <th scope="col">消費税</th>
                  <th scope="col">総計</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>{{ $ys->subject_name }}</td>
                  <td>¥{{ number_format($ys->year_subtotal) }}</td>
                  <td>¥{{ number_format($ys->year_sales_tax) }}</td>
                  <td>¥{{ number_format($ys->year_grand_total) }}</td>
               </tr>
            </tbody>
         </table>
      @endforeach
      </div><!-- .tab-content__item -->
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