<?php

namespace App\Controllers;

use App\Models\Lender;
use App\Models\Lending;
use App\Models\Thing;
use App\Http\Request;
use App\Exceptions\ModelInvalidException;
use App\Support\Facades\Response;

class Controller
{
    public function index(Request $request)
    {
        return Response::view('index');
    }

    public function add(Request $request)
    {
        return Response::view('add-lending');
    }

    public function addPost(Request $request)
    {
        // Create the Thing
        $thing = new Thing([
            'name' => $request->post('thing-name'),
            'type' => $request->post('thing-type'),
            'note' => $request->post('thing-note'),
        ]);

        // Create the Lender
        $lender = new Lender([
            'name' => $request->post('lender-name'),
            'email' => $request->post('lender-email'),
            'phone' => $request->post('lender-phone'),
        ]);

        // Create the Lending
        $date = $request->post('lending-date');
        $date = explode('-', $date);
        $start = trim($date[0]);
        $end = trim(($date[1] ?? $date[0]));

        $lending = new Lending([
            'date_start' => date('Y-m-d', strtotime($start)),
            'date_end' => date('Y-m-d', strtotime($end)),
        ]);

        try {
            $thing->validate();
            $lender->validate();
            $lending->validate();

            Response::success('Empréstimo adicionado.');

            return Response::view('lending');
        } catch (ModelInvalidException $e) {
            Response::error($e->getMessage());
        } catch (Exception $e) {
            Response::error('Não foi possível salvar seu empréstimo.');
        }

        return Response::view('add-lending');
    }
}
