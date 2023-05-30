<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Auth;

class CompaniesUsers extends Model
{
    protected $fillable = [
        'id_user',
        'id_company',
    ];

    public static function setCompaniesUsers(){

        $companies_users=CompaniesUsers::select('id_company')->where('id_user',Auth::user()->id)->get();

        /*foreach($companies_users as $company){
            $companies[]=$company['id_company'];

        }   */
        return $companies_users;
    }

   
}