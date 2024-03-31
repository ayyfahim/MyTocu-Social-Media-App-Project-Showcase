<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\State;

class CountryController extends Controller
{
    public function getStates(Country $country)
    {
        return $country->states()->select('id', 'name')->get();
    }

    function fetch(Request $request)
    {
        $select = $request->select;
        $value = $request->get('value');
        $dependent = $request->get('dependent');


        if ($select=="country") {
            $datas = State::where('country_id', $value)->get();
        }

        elseif ($select=="state") {
            $datas = City::where('state_id', $value)->get();
        }

        $output = '<option value="">Select '.ucfirst($dependent).'</option>';

        foreach ($datas as $data) {
            $output .= '<option value="'.$data['id'].'">'.$data['name'].'</option>';
        }
        echo $output;
    }

}
