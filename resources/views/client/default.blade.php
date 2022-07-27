@extends("crudbooster::admin_template")
@section("content")

<div id="xapp">
   <div class="panel panel-info">
      <div class="panel-heading">
         Attandance
         <div class="pull-right">
			Accountant Name : @{{account[0].name}}
			
		
			<input type="hidden" v-model="aid">
         </div>
      </div>
      <div class="panel-body">
		<center>
         <form class="form-inline">
			<p v-if="errors.length">
			<b>Please correct the following error(s):</b>
			<ul style="list-style:none;color:red;">
			<li v-for="error in errors">@{{ error }}</li>
			</ul>
			</p>
            <div class="form-group">
               <label>Find Client</label>
				<select  v-model="selclient" class="form-control select2" id="client" name="client">
					<option>--Select Client--></option>
					<option value="all">All</option>
					<option v-for="c in client" :value="c.id">@{{c.name}}</option>
				</select>
            </div>
            
            <div class="form-group">
               <label>Between Tod Date</label>
               <input  v-model="selstartdate" class="form-control" placeholder="Select From Date" type="date">
			  <input  v-model="selectenddate" class="form-control" placeholder="Select To Date" type="date">
            </div>
			
			
			<div class="clearfix"></div><br/>
            <div class="form-group">
               <button type="button" class="btn btn-info" @click="search"><i class="fa fa-search"></i>&nbsp;Search</button>
            </div>
         </form>
		 </center>
		 <hr>
			<div class="row" v-if="datax.length>0">
			
			<div class="col-sm-12 col-md-12 col-lg-12">
			  <table class="table table-hover table-striped table-bordered">
				<thead>
					<tr class="active">
						<th scope="col">#</th>
						<th scope="col">Client Name</th>
						<th scope="col">In Time</th>
						<th scope="col">Out Time</th>
						<th scope="col">Total Hourse</th>
						<th scope="col">Date</th>
					</tr>
					</thead>
					<tbody>
						<tr v-for="(d,index) in datax">
							<th scope="row" >@{{index+1}}</th>
							<td>@{{d.client.name}}</td>
							<td>@{{d.intime}}</td>
							<td  v-if="d.outtime!=null" >@{{d.outtime}}</td>
							<td v-else style="background:red;color:white">@{{d.outtime}}</td>
							<td v-if="d.totalhours!=null || d.totalhours!=''">@{{d.totalhours}}</td>
							<td v-else style="background:red;color:white">@{{d.totalhours}}</td>
							<td>@{{d.created_at}}</td>
							
						</tr>
						
					</tbody>
				</table>
			</div>
			</div>
      </div>
   </div>
   
 
</div>

<style>
.profile {
  margin: 20px 0;
}



.profile-usertitle {
  text-align: center;
  margin-top: 20px;
}

.profile-usertitle-name {
  color: #5a7391;
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 7px;
}

.profile-usertitle-job {
  text-transform: uppercase;
  color: #5b9bd1;
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 15px;
}

</style>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
<script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

  new Vue({
    el: '#xapp',
	components: {
    },
    data: {
      	errors:[],
		account:<?php echo json_encode($accountant);?>,
		client:<?php echo $client;?>,
		selclient:'',
		selstartdate:'',
		selectenddate:'',
		datax:[],
		user:[],
		aid:<?php echo $accountant[0]->id;?>,
		
		
	},
	watch: {
		
	},
	mounted: function() {
     
	},
	methods:{
		search:function(){
			this.errors=[];
			if(!this.selclient){
				this.errors.push('Select Client Name');
				return false;
			}
			if(!this.selstartdate){
				this.errors.push('Select Start Date');
				return false;
			}
			if(!this.selectenddate){
				this.errors.push('Select End Date');
				return false;
			}
			
			 NProgress.start();
			 self=this;
			 
			axios.get('/api/v1/getAttandance?clientId=' + this.selclient + '&startdate=' + this.selstartdate + '&enddate=' + this.selectenddate+'&accountid='+this.aid).then(response => {
				  NProgress.done()
				  this.datax=response.data.data;
				 
				  this.user=response.data.user;
			});
			
		}

	}
 });

</script>
@endsection
