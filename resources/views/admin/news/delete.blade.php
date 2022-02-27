<div class="modal fade" id="deletePost" tabindex="-1" role="dialog" aria-labelledby="deletePost" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deletePost">Da li ste sigurni?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="tijelo">
          Da li ste sigurni da želiš da obrišeš ovu vijest? 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
          <form id="formaBrisanje" action="" method="POST">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger">Izbriši</button>
          </form>
        </div>
      </div>
    </div>
  </div>