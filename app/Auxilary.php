<?php

use App\Dieuw;
use App\Daara;
use App\Talibe;
use App\Medecin;
use App\Tarbiya;

if(!function_exists('app_date_reverse'))
{
	function app_date_reverse($date,$sep,$glue)
	{
		return implode($glue, array_reverse(explode($sep, $date))) ;
	}
}

if( !function_exists('nb_daaras'))
{
	function nb_daaras()
	{
		return Daara::all()->count();
	}
}

if(!function_exists('nb_talibes'))
{
	function nb_talibes()
	{
		return (int) Talibe::all()->count();
	}
}

if(!function_exists('nb_dieuws'))
{
	function nb_dieuws()
	{
		return (int) Dieuw::all()->count();
	}
}

if(!function_exists('nb_medecins'))
{
    function nb_medecins()
    {
        return (int) Medecin::all()->count();
    }
}

if(!function_exists('nb_tarbiyas'))
{
    function nb_tarbiyas()
    {
        return (int) Tarbiya::all()->count();
    }
}

if(!function_exists('niveau_mapper'))
{
	function niveau_mapper()
	{
		$levels = [];
	}
}

if(!function_exists('app_real_filename'))
{
	 function app_real_filename($str)
	{

	    return explode('/', $str)[1];
	}
}

if(!function_exists('fullName'))
{
    function fullName($prenom, $nom)
    {
        return ucfirst(strtolower($prenom)).' '.strtoupper($nom);
    }
}
?>
