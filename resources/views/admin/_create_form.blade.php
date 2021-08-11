<!-- モーダルボタン -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
  ユーザー登録
  </button>
</div>

<!-- モーダル・伝票登録フォーム -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">ユーザー登録</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="{{ route('account.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">名前</label>
                <input type="text" name="name" class="form-control" id="name">
            </div>
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" class="form-control" id="email">
            </div>
            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
            <div class="form-group">
                <label for="confirm_password">パスワード（確認）</label>
                <input type="password" name="confirm_password" class="form-control" id="confirm_password">
            </div>
            <div class="form-check">
              <input type="hidden" name="is_active" class="form-check-input" id="is_active" value="0">
              <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1">
              <label class="form-check-label" for="is_active">アカウント無効</label>
            </div>
            <div class="form-check">
              <input type="hidden" name="role" class="form-check-input" id="role" value="0">
              <input type="checkbox" name="role" class="form-check-input" id="role" value="1">
              <label class="form-check-label" for="role">管理者権限</label>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">登録する</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
        </div>
      </div>
  </div>
</div>