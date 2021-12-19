<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create/Update</h5>                
            </div>
            <form id='insert-record'>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">SPID:</label>
                        <input type="hidden" name="id" id="id">
                        <?= form_input('spid', '', 'id="spid" class="form-control" maxlength="18" required=""');?>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Hostname:</label>
                        <?= form_input('hostname', '', 'id="hostname" class="form-control" maxlength="14" required=""')?>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Loopback:</label>
                        <?= form_input('loopback', '', 'id="loopback" class="form-control" maxlength="18" required=""')?>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">MAC Address:</label>
                        <?= form_input('mac', '', 'id="mac" class="form-control" maxlength="17" required=""')?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>