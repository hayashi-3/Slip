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
    <div class="parent-row">
      <div class="c-row ajast">支払方法</div>
      <div class="c-row ajast-middle">科目名</div>
      <div class="c-row ajast">発生日</div>
      <div class="c-row ajast">金額</div>
      <div class="c-row ajast">小計</div>
      <div class="c-row ajast-middle">消費税率</div>
      <div class="c-row ajast">消費税額</div>
      <div class="c-row ajast">総計</div>
      <div class="c-row ajast">備考</div>
      <div class="c-row ajast-narrow">編集</div>
      <div class="c-row ajast-narrow">保存</div>
      <div class="c-row ajast-narrow">閉じる</div>
      <div class="c-row ajast-narrow">削除</div>
      <hr>
    </div>
    @foreach($m_summary_slip as $ms_slip)
      <div class="parent-row data-edit">
        @include('month_summary._edit_form')
        <hr>
      </div>
    @endforeach
  </div>
  <div>{{ $m_summary_slip->links() }}</div>
@endsection