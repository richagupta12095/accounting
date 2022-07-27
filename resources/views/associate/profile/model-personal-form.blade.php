<div class="modal fade" id="edit_personal_details" aria-hidden="true" role="dialog">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Personal Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frm-user-info" name="frm-user-info">
            <div class="row form-row">
                <div class="col-12 col-sm-12">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" class="form-control" value="" name="name" v-model="name">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <div class="cal-icon">
                        <vuejs-datepicker input-class="form-control"  name="dob" v-model="dob"></vuejs-datepicker>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Experince</label>
                        <input type="number" class="form-control" name="experince" value=""  v-model="exp">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Qualification</label>
                       <select class="form-control" v-model="qfincation" name="qualification">
                                <option value="">Select Qualification</option>
                                <option v-for="item in qualification" v-bind:selected="item.id == qfincation" v-bind:value="item.id">@{{item.qualification}}</option>
                       </select>
                        
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>ICAI Number</label>
                        <input type="text" class="form-control" name="icai_number" value=""  v-model="icainumber">
                        
                    </div>
                </div>

            </div>
            <button type="button" v-on:click="updateUserinfo" class="btn btn-primary btn-block">Save Changes</button>
            </form>
        </div>
    </div>
</div>
</div>
