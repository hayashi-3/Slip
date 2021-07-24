@extends('layouts.app')

@section('content')
 <!-- フラッシュメッセージ -->
 @if (session('flash_message'))
   <div class="alert alert-success">
      {{ session('flash_message') }}
   </div>
@endif

<div class="container">

   <div class="row">
      <form>
         @csrf
         <button type="submit" class="btn btn-outline-success mr-3">伝票を読み取る</button>
      </form>
   
   <!-- 新規登録フォーム -->
   @include('slip/_create_form')

   <h4 class="mt-3">今月の支出　¥{{ number_format($gtotal_sl) }} (税込)</h4>

   <ul class="tab-menu">
      <li class="tab-menu__item">
         <span class="tab-trigger js-tab-trigger is-active" data-id="tab01">
           {{ \Carbon\Carbon::now()->format("Y年m月") }} 
         </span>
      </li>
   </ul>

   <div class="tab-content">
   <div class="tab-content__item js-tab-target is-active" id="tab01">

   <table class="table">
      <thead>
         <tr>
         <th scope="col"></th>
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
      @foreach ($slip as $sl)
         <tr>
            <th scope="row">{{ $sl->id }}</th>
            @foreach ($subject as $sb)
            @if ($sl->subject_id == $sb->id)
               <td>{{ $sb->subject_name }}</td>
            @endif
            @endforeach
            <td>{{ $sl->accrual_date }}</td>
            <td>¥{{ number_format($sl->price) }}</td>
            <td>¥{{ number_format($sl->subtotal) }}</td>
            <td>{{ $sl->sales_tax_rate }}%</td>
            <td>¥{{ number_format($sl->sales_tax) }}</td>
            <td>¥{{ number_format($sl->grand_total) }}</td>
            <td>{{ $sl->remarks }}</td>
            <td><!-- モーダルボタン -->
               <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#edit{{ $sl->id }}">
                  伝票編集
               </button>
                <!-- モーダル・伝票登録フォーム -->
                  <div class="modal fade" id="edit{{ $sl->id }}" tabindex="-1" role="dialog" aria-labelledby="#editModal" aria-hidden="true">
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
                              <input type="hidden" name="id" value="{{ $sl->id}}">
                              <div class="form-group">
                                 <label for="subject">科目</label>
                                 <select name="subject_id" class="form-control" id="subject">
                                    @foreach($subject as $sb)
                                       <option value="{{ $sb->id }}">{{ $sb->subject_name }}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="form-group">
                                 <label for="date">日付</label>
                                 <input type="date" name="accrual_date" class="form-control" id="date" value="{{ $sl->accrual_date }}">
                              </div>
                              <div class="form-group">
                                 <label for="price">単価</label>
                                 <input type="number" name="price" class="form-control" id="price" value="{{ $sl->price }}">
                              </div>
                              <div class="form-group">
                                 <label for="sb">本体金額</label>
                                 <input type="number" name="subtotal" class="form-control" id="sb" value="{{ $sl->subtotal }}">
                              </div>
                              <div class="form-group">
                                 <label for="st_rate">消費税率(%)</label>
                                 <input type="number" name="sales_tax_rate" class="form-control" id="st_rate" value="{{ $sl->sales_tax_rate }}">
                              </div>
                              <div class="form-group">
                                 <label for="s_tax">消費税金額</label>
                                 <input type="number" name="sales_tax" class="form-control" id="s_tax" value="{{ $sl->sales_tax }}">
                              </div>
                              <div class="form-group">
                                 <label for="g_total">総計金額</label>
                                 <input type="number" name="grand_total" class="form-control" id="g_total" value="{{ $sl->grand_total }}">
                              </div>
                              <div class="form-group">
                                 <label for="rmark">備考</label>
                                 <input type="text" name="remarks" class="form-control rmark" value="{{ $sl->remarks }}">
                              </div>
                              <button type="submit" class="btn btn-primary btn-lg btn-block">更新する</button>
                           </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                        </div>
                     </div>
                  </div>
               </div>
            </td>
            <td>
               <form method="post" action="{{ route('slip.delete', $sl->id) }}">
                  @csrf
                  <button type="submit" class="btn btn-outline-danger">削除</button>
               </form>
            </td>
         </tr>

   @endforeach
   </tbody>
  </table>
   </div><!-- .tab-content__item -->
   </div><!-- .tab-content -->

   <div class="mt-5">
      <canvas id="myPieChart"></canvas>
      <script type="text/javascript">
        var subject_names = '<?php echo implode(",", current($subject_names)) ?>';
      </script>
   </div>
</div>

@endsection