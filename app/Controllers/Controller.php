<?php

namespace App\Controllers;

use App\Models\Lender;
use App\Models\Lending;
use App\Models\Thing;
use App\Http\Request;
use App\Exceptions\ModelInvalidException;
use App\Support\Facades\Response;
use App\Support\Logger;

class Controller
{
    /**
     * Show the index
     *
     * @param  Request $request
     * @return Response::view
     */
    public function index(Request $request)
    {
        return Response::view('index');
    }

    /**
     * Show the New Lending view
     *
     * @param Request $request
     * @return Response::view
     */
    public function add(Request $request)
    {
        return Response::view('add-lending');
    }

    /**
     * Show a lending
     *
     * @param  Request $request
     * @return Response::view
     */
    public function show(Request $request)
    {
        $model = Lending::find($request->params('id'));
        if (empty($model)) {
            Response::abort(404);
        }

        return Response::view('lending', ['lending' => $model]);
    }

    /**
     * Show a lending
     *
     * @param  Request $request
     * @return Response::view
     */
    public function delete(Request $request)
    {
        try {
            $model = Lending::find($request->params('id'));
            if (! empty($model) && $model->delete()) {
                Response::success('Empréstimo removido.');
                return Response::back();
            }
        } catch (Exception $e) {
            Logger::error($e->getMessage());
        }

        Response::error('Não foi possível remover seu empréstimo.');
        return Response::back();
    }

    /**
     * Process the POST for add a new Lending
     *
     * @param Request $request
     * @return Response::view
     */
    public function updatePost(Request $request)
    {
        $editing = true;

        // If a ID is provided, try to find the models
        $id = $request->params('id');
        if (! empty($id)) {
            $lending = Lending::find($id);
            $thing = Thing::find($lending->thing_id);
            $lender = Lender::find($lending->lender_id);
        }

        // Create new Models if empty
        if (empty($lending)) {
            $editing = false;
            $lending = new Lending();
        }

        if (empty($thing)) {
            $thing = new Thing();
        }

        if (empty($lender)) {
            $lender = new Lender();
        }

        // Fill the Models
        $thing->fill([
            'name' => $request->post('thing-name'),
            'type' => $request->post('thing-type'),
            'note' => $request->post('thing-note'),
        ]);

        // Create the Lender
        $lender->fill([
            'name' => $request->post('lender-name'),
            'email' => $request->post('lender-email'),
            'phone' => $request->post('lender-phone'),
        ]);

        // Create the Lending
        $date = $request->post('lending-date');
        $date = explode('-', $date);

        $start = trim($date[0]);
        $end = trim(($date[1] ?? $date[0]));

        $start = str_replace('/', '-', $start);
        $end = str_replace('/', '-', $end);

        $lending->fill([
            'date_start' => date('Y-m-d', strtotime($start)),
            'date_end' => date('Y-m-d', strtotime($end)),
        ]);

        try {
            $thing->validate();
            $lender->validate();
            $lending->validate();

            $lending->thing_id = $thing->save();
            $lending->lender_id = $lender->save();

            $id = $lending->save();

            $message = ($editing) ? 'Empréstimo atualizado.' : 'Empréstimo adicionado.';
            Response::success($message);

            return Response::redirect('emprestimo/' . $id);
        } catch (ModelInvalidException $e) {
            Logger::error($e->getMessage());

            Response::error($e->getMessage());
        } catch (Exception $e) {
            Logger::error($e->getMessage());

            $message = ($editing) ? 'Não foi possível alterar seu empréstimo.' : 'Não foi possível salvar seu empréstimo.';
            Response::error($message);
        }

        return Response::back();
    }
}
