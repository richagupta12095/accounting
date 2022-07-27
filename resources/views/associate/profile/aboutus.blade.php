.<div class="modal fade" id="edit_about_us" aria-hidden="true" role="dialog">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">About us</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frm-about-info" name="frm-address-info">
            <div class="row form-row">
                <div class="col-12 col-sm-12">
                    <div class="form-group">
                        <label>Tell about your self</label>
                         <textarea class="form-control" rows="8" v-model="aboutus" name="aboutus"></textarea>
                    </div>
                </div>


            </div>
            <button type="button" v-on:click="updateaboutus"  class="btn btn-primary btn-block">Save Changes</button>
            </form>
        </div>
    </div>
</div>
</div>
