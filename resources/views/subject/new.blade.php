@extends('layouts.app')

@section('content')
<!-- フラッシュメッセージ -->
@if (session('flash_message'))
   <div class="alert alert-success">
      {{ session('flash_message') }}
   </div>
@endif

<div class="container">
  <h4>科目新規登録</h4>
  <div class="card"></div>

  <form method="post" action="{{ route('subject.store') }}">
    @csrf
    <div class="form-group">
      <label for="s_name">科目名</label>
      <input type="text" class="form-control" name="subject_name" id="s_name">
    </div>
    <div class="form-group">
      <label for="cal">計算方法</label>
      <p>税込金額 × <input type="number" step="0.01" class="form-control" name="calculation" id="cal"></p>
    </div>
    <button type="submit" class="btn btn-primary">登録する</button>
  </form>

</div>
@endsection
