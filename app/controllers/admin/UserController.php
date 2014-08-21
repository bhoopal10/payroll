<?php 
namespace App\Controller\Admin;
class UserController extends ControllerBase
{
	public function getView()
	{
		
	}
	public function getCreate()
	{
		return \View::make('admin/user.create');
	}
	public function postCreate()
	{
		echo "<pre>";
		$uId=\Auth::user()->id;
		/*creating rows to multiple table so here use in transaction*/
           \DB::beginTransaction();
		//Company general info
		$company_name      =	\Input::get('company_name');
		$company_address   =	\Input::get('company_address');
		$company_city      =	\Input::get('company_city');
		$company_state     =	\Input::get('company_state');
		$company_pin       =	\Input::get('company_pin');
		$company_country   =	\Input::get('company_country');
		$company_phone     =	\Input::get('company_phone');
		$company_alt_phone =	\Input::get('company_alt_phone');
		$company_email     =	\Input::get('company_email');
		$company_alt_email =	\Input::get('company_alt_email');
		$company_website   =	\Input::get('company_website');
		//insert company genral information
		$comp_id           =\Company::insertGetId(array(
			'company_name'      =>	$company_name,
			'company_address'   =>	$company_address,
			'company_city'      =>	$company_city,
			'company_state'     =>	$company_state,
			'company_pin'       =>	$company_pin,
			'company_country'   =>	$company_country,
			'company_phone'     =>	$company_phone,
			'company_alt_phone' =>	$company_alt_phone,
			'company_email'     =>	$company_email,
			'company_alt_email' =>	$company_alt_email,
			'company_website'   =>	$company_website,
			'user_id'           =>	$uId
			));
		if(!$comp_id)
		{
			\DB::rollback();
			return \Redirect::back()->with('error','failed to create try again');
		}
		//contact_info
		$primary_contact_person   = \Input::get('primary_contact_person');
		$primary_phone            = \Input::get('primary_phone');
		$primary_alt_phone        = \Input::get('primary_alt_phone');
		$primary_email            = \Input::get('primary_email');
		$primary_alt_email        = \Input::get('primary_alt_email');
		$secondary_contact_person = \Input::get('secondary_contact_person');
		$secondary_phone          = \Input::get('secondary_phone');
		$secondary_alt_phone      = \Input::get('secondary_alt_phone');
		$secondary_email          = \Input::get('secondary_email');
		$secondary_alt_email      = \Input::get('secondary_alt_email');
		// Insert company contact
		$contactId=\CompanyContact::insertGetId(array(
					'primary_contact_person'   =>	$primary_contact_person,
					'primary_phone'            =>	$primary_phone,
					'primary_alt_phone'        =>	$primary_alt_phone,
					'primary_email'            =>	$primary_email,
					'primary_alt_email'        =>	$primary_alt_email,
					'secondary_contact_person' =>	$secondary_contact_person,
					'secondary_phone'          =>	$secondary_phone,
					'secondary_alt_phone'      =>	$secondary_alt_phone,
					'secondary_email'          =>	$secondary_email,
					'secondary_alt_email'      =>	$secondary_alt_email,
					'company_id'			   =>	$comp_id,
					'user_id'				   =>	$uId
			));
		if(!$contactId)
		{
			\DB::rollback();
			return \Redirect::back()->with('error', 	'failed to create try again');
		}
		// company registration information
		$reg_pan                = \Input::get('reg_pan'); 
		$reg_tan                = \Input::get('reg_tan'); 
		$reg_incorporation_date =implode('-',array_reverse(explode('/',\Input::get('reg_incorporation_date')))) ;
		$reg_tan_circle         = \Input::get('reg_tan_circle'); 
		$reg_cin                = \Input::get('reg_cin');
		// Insert company registration
		$regId                  = \CompanyRegistration::insertGetId(array(
					'reg_pan'                => $reg_pan,
					'reg_tan'                => $reg_tan,
					'reg_incorporation_date' => $reg_incorporation_date,
					'reg_tan_circle'         => $reg_tan_circle,
					'reg_cin'                => $reg_cin,
					'user_id'                => $uId,
					'company_id'             => $comp_id
	    			));
		if(!$regId)
		{
			\DB::rollback();
			return \Redirect::back()->with('error','failed to create try again');
		}
		//Profssional tax information
		$pt                   =  \Input::get('pt');
		$pt_registration_date =implode('-',array_reverse(explode('/', \Input::get('pt_registration_date')))) ;
		$pt_signatory_name    = \Input::get('pt_signatory_name');
		//Insert professional tax
		$profTaxId            =\CompanyProfessionalTax::insertGetId(array(
								'pt'                   => $pt,
								'pt_registration_date' => $pt_registration_date,
								'pt_signatory_name'    => $pt_signatory_name,
								'user_id'              => $uId,
								'company_id'           => $comp_id
								));
		if(!$profTaxId)
		{
			\DB::rollback();
			return \Redirect::back()->with('error','failed to create try again');
		}
		//Provident Fund Info
		$provident_fund                  = \Input::get('provident_fund');
		$provident_registration_date     =implode('-',array_reverse(explode('/',\Input::get('provident_registration_date')))) ;
		$provident_signatory_name        = \Input::get('provident_signatory_name');
		$provident_signatory_designation = \Input::get('provident_signatory_designation');
		$provident_signatory_father_name = \Input::get('provident_signatory_father_name');
		$provident_company_level_pf      = \Input::get('provident_company_level_pf');
		// Insert Provident fund info
		$providentId                     =\CompanyProvident::insertGetId(array(
						'provident_fund'                  => $provident_fund,
						'provident_registration_date'     => $provident_registration_date,
						'provident_signatory_name'        => $provident_signatory_name,
						'provident_signatory_designation' => $provident_signatory_designation,
						'provident_signatory_father_name' => $provident_signatory_father_name,
						'provident_company_level_pf'      => $provident_company_level_pf,
						'user_id'                         => $uId,
						'company_id'                      => $comp_id
	    				));
		if(!$providentId)
		{
			\DB::rollback();
			return \Redirect::back()->with('error','failed to create try again');
		}
		// ESI Information
		$esi                       = \Input::get('esi');
		$esi_registration_date     =implode('-',array_reverse(explode('/',\Input::get('esi_registration_date')))) ;
		$esi_signatory_name        = \Input::get('esi_signatory_name');
		$esi_signatory_desgnation  = \Input::get('esi_signatory_desgnation');
		$esi_signatory_father_name = \Input::get('esi_signatory_father_name');
		// Insert  ESI information
		$esiId                     =\CompanyEsi::insertGetId(array(
							'esi'                       => $esi,
							'esi_registration_date'     => $esi_registration_date,
							'esi_signatory_name'        => $esi_signatory_name,
							'esi_signatory_desgnation'  => $esi_signatory_desgnation,
							'esi_signatory_father_name' => $esi_signatory_father_name,
							'user_id'					=> $uId,
							'company_id'				=> $comp_id
	    					));
		if(!$esiId)
		{
			\DB::rollback();
			return \Redirect::back()->with('error','failed to create try again');
		}
		// incometax information
		$itax_signatory_name        = \Input::get('itax_signatory_name') ;
		$itax_signatory_desgnation  = \Input::get('itax_signatory_desgnation') ;
		$itax_signatory_father_name = \Input::get('itax_signatory_father_name') ;
		$cit                        = \Input::get('cit') ;
		$itax_address               = \Input::get('itax_address') ;
		$itax_city                  = \Input::get('itax_city') ;
		$itax_pin                   = \Input::get('itax_pin') ;
		// Insert Income tax details
		$taxId                      = \CompanyIncomeTax::insertGetId(array(
										'itax_signatory_name'        => $itax_signatory_name,
										'itax_signatory_desgnation'  => $itax_signatory_desgnation,
										'itax_signatory_father_name' => $itax_signatory_father_name,
										'cit'                        => $cit,
										'itax_address'               => $itax_address,
										'itax_city'                  => $itax_city,
										'itax_pin'                   => $itax_pin,
										'user_id'                    => $uId,
										'company_id'                 => $comp_id
										));
		if(!$taxId)
		{
			\DB::rollback();
			return \Redirect::back()->with('error','failed to create try again');
		}
		elseif($taxId)
		{
			\DB::commit();
			return \Redirect::to('/admin')->with('success','successfully created');
		}
		
	}
	public function getLabourLawInformation()
	{
		return \View::make('admin/labour_law.labour_law_information');
	}
	public function postLabourLawInformation()
	{
		echo "<pre>";
		print_r(\Input::all());
	}
	public function getBankDetail()
	{
		$uId=\Auth::user()->id;
		$bank=\BankDetail::where('user_id','=',$uId)->paginate(15);
		return \View::make('admin/bank.bank_detail')->with('bank',$bank);
	}
	public function postBankDetail()
	{
		// Bank details
		$uId          =  \Auth::user()->id;
		$bank_name    =  \Input::get('bank_name');
		$account_no   =  \Input::get('account_no');
		$account_type =  \Input::get('account_type');
		$branch       =  \Input::get('branch');
		$micr_no      =  \Input::get('micr_no');
		$ifsc_code    =  \Input::get('ifsc_code');
		$status       =  \Input::get('status');
		// Insert into table
		$bankId       = \BankDetail::insertGetId(array(
							'bank_name'    => $bank_name,
							'account_no'   => $account_no,
							'account_type' => $account_type,
							'branch'       => $branch,
							'micr_no'      => $micr_no,
							'ifsc_code'    => $ifsc_code,
							'status'       => $status,
							'user_id'      => $uId
			    			));
		if($bankId)
		{
			return \Redirect::back()->with('success','Bank details successfully added');
		}
		else
		{
			return \Redirect::back()->with('error','Bank detail failed to add');
		}
		
	}
}