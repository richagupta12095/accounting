<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
		use Hash;
	use Mail;
	class AdminCmsUsers15Controller extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "name";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "cms_users";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Photo","name"=>"photo","image"=>true];
			$this->col[] = ["label"=>"Name","name"=>"name"];
			$this->col[] = ["label"=>"Mobile","name"=>"mobile"];
			$this->col[] = ["label"=>"Wallet","name"=>"Wallet"];
			$this->col[] = ["label"=>"Privileges","name"=>"id_cms_privileges","join"=>"cms_privileges,name"];
			$this->col[] = ["label"=>"Commission","name"=>"commission"];
			$this->col[] = ["label"=>"Referral Code","name"=>"referalcode"];
			$this->col[] = ["label"=>"Reffer By","name"=>"refferby"];
			//$this->col[] = ["label"=>"Company Name","name"=>"company_name"];
			//	$this->col[] = ["label"=>"Status","name"=>"status"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			$this->form[] = ['label'=>'Gst No','name'=>'gst_no','type'=>'text','validation'=>'string|min:15|max:15','width'=>'col-sm-10','help'=>'GST Number or leave empty if you not have'];
			$this->form[] = ['label'=>'Company Name','name'=>'company_name','width'=>'col-sm-9','placeholder'=>'Please enter a Company Name'];
			$this->form[] = ['label'=>'Email','name'=>'email','type'=>'email','validation'=>'required|min:1|max:255|email|unique:cms_users','width'=>'col-sm-10','help'=>'Please enter email info@gmail.com'];
			//$this->form[] = ['label'=>'Password','name'=>'password','type'=>'password','validation'=>'required|min:6|max:32','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Mobile','validation'=>'required|min:10|max:10','name'=>'mobile','type'=>'text','width'=>'col-sm-10'];
		
			$this->form[] = ['label'=>'State','name'=>'state','type'=>'select2','width'=>'col-sm-10','datatable'=>'state,StateName'];
			$this->form[] = ['label'=>'City','name'=>'city','type'=>'text','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Address','name'=>'address','type'=>'textarea','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Pin code','name'=>'pincode','type'=>'text','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Privileges','name'=>'id_cms_privileges','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'cms_privileges,name',"datatable_where"=>"id=5"];
			$this->form[] = ['label'=>'Status','name'=>'status','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10','dataenum'=>'Active;In-Active'];
			$this->form[] = ['label'=>'Photo','name'=>'photo','type'=>'upload','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'QR Code','name'=>'qrcode','type'=>'text','width'=>'col-sm-10','placeholder'=>'QR Code'];
			$this->form[] = ['label'=>'Commission','name'=>'commission','type'=>'number','width'=>'col-sm-10','placeholder'=>'Commission'];
			$this->form[] = ['label'=>'Referral Code','name'=>'referalcode','type'=>'text','validation'=>'required|min:6|max:10|unique:cms_users','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Name","name"=>"name","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:3|max:70","placeholder"=>"You can only enter the letter only"];
			//$this->form[] = ["label"=>"Photo","name"=>"photo","type"=>"upload","required"=>TRUE,"validation"=>"required|image|max:3000","help"=>"File types support : JPG, JPEG, PNG, GIF, BMP"];
			//$this->form[] = ["label"=>"Email","name"=>"email","type"=>"email","required"=>TRUE,"validation"=>"required|min:1|max:255|email|unique:cms_users","placeholder"=>"Please enter a valid email address"];
			//$this->form[] = ["label"=>"Password","name"=>"password","type"=>"password","required"=>TRUE,"validation"=>"min:3|max:32","help"=>"Minimum 5 characters. Please leave empty if you did not change the password."];
			//$this->form[] = ["label"=>"Cms Privileges","name"=>"id_cms_privileges","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"cms_privileges,name"];
			//$this->form[] = ["label"=>"Status","name"=>"status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Remember Token","name"=>"remember_token","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Mobile","name"=>"mobile","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Country","name"=>"country","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"State","name"=>"state","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"City","name"=>"city","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Pincode","name"=>"pincode","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Address","name"=>"address","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Qualification","name"=>"qualification","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Company Name","name"=>"company_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Gst No","name"=>"gst_no","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			# OLD END FORM

			/*
	        | ----------------------------------------------------------------------
	        | Sub Module
	        | ----------------------------------------------------------------------
			| @label          = Label of action
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        |
	        */
	        $this->sub_module = array();


	        /*
	        | ----------------------------------------------------------------------
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------
	        | @label       = Label of action
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        |
	        */
		
			$this->sub_module[] = ['label' => 'Summery', 'path' => 'summery', 'parent_columns' => 'name', 'foreign_key' => 'clientId', 'button_color' => 'success', 'button_icon' => 'fa fa-globe'];
			$this->sub_module[] = ['label' => 'Balance Sheet', 'path' => 'balance_sheet', 'parent_columns' => 'name', 'foreign_key' => 'clientId', 'button_color' => 'info', 'button_icon' => 'fa fa-history'];
			$this->sub_module[] = ['label' => 'Schedules Report', 'path' => 'schedules_report', 'parent_columns' => 'name', 'foreign_key' => 'clientId', 'button_color' => 'info', 'button_icon' => 'fa fa-globe'];
       
		/*	$this->addaction[] = ['label'=>'In Active','url'=>CRUDBooster::mainpath('set-status/Active/[id]'),'icon'=>'fa fa-check','color'=>'success','showIf'=>"[status]=='In-Active'"];
			$this->addaction[] = ['label'=>'Active','url'=>CRUDBooster::mainpath('set-status/In-Active/[id]'),'icon'=>'fa fa-ban','showIf'=>"[status]=='Active'",'color'=>'warning', 'confirmation' => true];*/
			



	        /*
	        | ----------------------------------------------------------------------
	        | Add More Button Selected
	        | ----------------------------------------------------------------------
	        | @label       = Label of action
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button
	        | Then about the action, you should code at actionButtonSelected method
	        |
	        */
	        $this->button_selected = array();


	        /*
	        | ----------------------------------------------------------------------
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------
	        | @message = Text of message
	        | @type    = warning,success,danger,info
	        |
	        */
	        $this->alert        = array();



	        /*
	        | ----------------------------------------------------------------------
	        | Add more button to header button
	        | ----------------------------------------------------------------------
	        | @label = Name of button
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        |
	        */
	        $this->index_button = array();



	        /*
	        | ----------------------------------------------------------------------
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
	        |
	        */     
		   $this->table_row_color[] = ["condition"=>"[status] == 'Active'","color"=>"success"];
		   $this->table_row_color[] = ["condition"=>"[status] == 'In-Active'","color"=>"warning"];


	        /*
	        | ----------------------------------------------------------------------
	        | You may use this bellow array to add statistic at dashboard
	        | ----------------------------------------------------------------------
	        | @label, @count, @icon, @color
	        |
	        */
	       $this->index_statistic[] = ['label'=>'Total Active Client','count'=>DB::table('cms_users')->where('id_cms_privileges','=',5)->where('status','=','Active')->count(),'icon'=>'fa fa-user','color'=>'green','width'=>'col-sm-3'];

			$this->index_statistic[] = ['label'=>'Total In-Active Client','count'=>DB::table('cms_users')->where('id_cms_privileges','=',5)->where('status','=','In-Active')->count(),'icon'=>'fa fa-user','color'=>'red','width'=>'col-sm-3'];



	        /*
	        | ----------------------------------------------------------------------
	        | Add javascript at body
	        | ----------------------------------------------------------------------
	        | javascript code in the variable
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ----------------------------------------------------------------------
	        | Include HTML Code before index table
	        | ----------------------------------------------------------------------
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;



	        /*
	        | ----------------------------------------------------------------------
	        | Include HTML Code after index table
	        | ----------------------------------------------------------------------
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;



	        /*
	        | ----------------------------------------------------------------------
	        | Include Javascript File
	        | ----------------------------------------------------------------------
	        | URL of your javascript each array
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();



	        /*
	        | ----------------------------------------------------------------------
	        | Add css style at body
	        | ----------------------------------------------------------------------
	        | css code in the variable
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;



	        /*
	        | ----------------------------------------------------------------------
	        | Include css File
	        | ----------------------------------------------------------------------
	        | URL of your css each array
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();


	    }

		
			public function getSetDocument($type=null,$id=null){
				if(empty($type) || empty($id)){
					return Redirect::back()->withErrors(['msg', 'The Message']);
				}
				
				$user=DB::table('cms_users')->where('id',$id)->get();
				return view('client.default')->with('client',$user);
				
			}
			
			
			public function getSetStatus($status,$id) {
				DB::table('cms_users')->where('id',$id)->update(['status'=>$status]);

			//This will redirect back and gives a message
				CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"The  user status has been updated !","info");
			}

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for button selected
	    | ----------------------------------------------------------------------
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here

	    }


	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate query of index result
	    | ----------------------------------------------------------------------
	    | @query = current sql query
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
			$query->where('id_cms_privileges','5');
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate row of index table html
	    | ----------------------------------------------------------------------
	    |
	    */
	    public function hook_row_index($column_index,&$column_value) {
	    	//Your code here
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate data input before add data is execute
	    | ----------------------------------------------------------------------
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {
	        //Your code here
			$postdata['password']=Hash::make($postdata['password']);
			if($postdata['status']==='Active'){
					/*Mail::send('emails.statusactive', ['data' => $postdata], function ($m) use ($postdata) {
						$m->from('info@capanel.in', 'Legalease Account Activation');
						$m->to($postdata['email'], $postdata['name'])->subject('Legalease Account Activation');
					});*/
			}
			
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after add public static function called
	    | ----------------------------------------------------------------------
	    | @id = last insert id
	    |
	    */
	    public function hook_after_add($id) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate data input before update data is execute
	    | ----------------------------------------------------------------------
	    | @postdata = input post data
	    | @id       = current id
	    |
	    */
	    public function hook_before_edit(&$postdata,$id) {
	        //Your code here
			 //Your code here
			if($postdata['status']==='Active'){
				
					Mail::send('emails.statusactive', ['data' => $postdata], function ($m) use ($postdata) {
						$m->from('info@capanel.in', 'Legalease Account Activation');
						$m->to($postdata['email'], $postdata['name'])->subject('Legalease Account Activation');
					});
			}
			if(!empty($postdata['password'])){
				$postdata['password']=Hash::make($postdata['password']);
			}else{
				$data=DB::table('cms_users')->where('id',$id)->select('password')->get();
				$postdata['password']=$data[0]->password;
			}
		if(empty($postdata['photo'])){

					$img =DB::table('cms_users')->select('photo')->where('id', $id)->get()->toArray();

					$postdata['photo']=$img[0]->photo;

				}

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_edit($id) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :)


	}