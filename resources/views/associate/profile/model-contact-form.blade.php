<div class="modal fade" id="edit_contact_details" aria-hidden="true" role="dialog">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Contact Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frm-address-info" name="frm-address-info">
            <div class="row form-row">
                <div class="col-12 col-sm-12">
                    <div class="form-group">
                        <label>Full Address</label>
                        <input type="text" class="form-control" v-model="full_address" name="full_address" value="">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" v-model="city" name="city" value="" >
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>State</label>
                        <select class="form-control" v-model="StateId" name="state">
                                <option value="">Select state</option>
                                <option v-for="item in state" v-bind:selected="item.id == StateId" v-bind:value="item.id">@{{item.StateName}}</option>
                       </select>
                    </div>
                </div>
               
                <div class="col-6">
                    <div class="form-group">
                        <label>Pincode</label>
                        <input type="text" class="form-control" value="" name="pincode" v-model="pincode">
                        
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label>Address Code</label>
                        <input type="text" class="form-control" value="" name="addresscode" v-model="addresscode">
                        
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Latitude</label>
                        <input type="text" class="form-control" value="" name="latitude" v-model="latitude">
                        
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Longitude</label>
                        <input type="number" class="form-control" value="" name="longitude" v-model="latitude">
                        
                    </div>
                </div>


            </div>
            <button type="button" v-on:click="updateaddressinfo"  class="btn btn-primary btn-block">Save Changes</button>
            </form>
        </div>
    </div>
</div>
</div>
