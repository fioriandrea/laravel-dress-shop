<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

use dress_shop\Address;
use dress_shop\DataLayer;

class AddressController extends Controller
{
    public function getAddAddress()
    {
        // create an address object with empty fields
        $address = new Address();
        return view('address_form', [
            'user' => auth()->user(),
            'address' => $address,
            'add' => true,
        ]);
    }

    public function getModifyAddress($id)
    {
        if (!$this->checkExists($id)) {
            // redirect to error page
            return redirect()->route('error', ['message' => 'Address does not exist']);
        }
        // find the address with the given id
        $address = Address::find($id);
        return view('address_form', [
            'user' => auth()->user(),
            'address' => $address,
            'add' => false,
        ]);
    }

    public function postAddAddress(Request $request)
    {
        DataLayer::postNewAddress($request);
        return redirect('/profile');
    }

    public function checkExists($id) {
        $address = Address::find($id);
        if ($address == null) {
            return false;
        }
        return true;
    }

    public function checkOwns($id) {
        $address = Address::find($id);
        if ($address == null) {
            return false;
        }
        if ($address->user_id != auth()->user()->id) {
            return false;
        }
        return true;
    }

    public function postRemoveAddress($id)
    {
        if (!$this->checkExists($id)) {
            return redirect()->route('error', ['message' => 'Address does not exist']);
        }
        if (!$this->checkOwns($id)) {
            return redirect()->route('error', ['message' => 'You do not own this address']);
        }
        DataLayer::postRemoveAddress($id);
        return redirect('/profile');
    }

    public function postModifyAddress(Request $request, $id)
    {
        if (!$this->checkExists($id)) {
            return redirect()->route('error', ['message' => 'Address does not exist']);
        }
        if (!$this->checkOwns($id)) {
            return redirect()->route('error', ['message' => 'You do not own this address']);
        }
        DataLayer::postModifyAddress($id, $request);
        return redirect('/profile');
    }
}
