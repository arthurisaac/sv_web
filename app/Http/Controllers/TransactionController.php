<?php

namespace App\Http\Controllers;

use App\Models\Enrole;
use App\Models\Transaction;
use App\Models\TransactionPartenaire;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactionsEnroles = Transaction::with("Sender")->with("Receiver")->get();
        $transactionsPartenaires = TransactionPartenaire::query()
            ->with('Sender')
            ->with('Receiver')
            ->get();
        return view("admin.transactions.index", compact("transactionsEnroles", "transactionsPartenaires"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $enroles = Enrole::query()
            ->orderBy("nom", "asc")
            ->get([
                'id',
                'nom',
                'prenom',
                'uniq',
                'balance',
                'created_at',
            ]);
        return view('admin.transactions.create', compact('enroles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        $receiver = Enrole::query()
        ->where("uniq", $request->get("receiver"))->get([
            'id',
            'nom',
            'prenom',
            'created_at',
            'balance',
            ])->first();

        $transfert = new Transaction([
            'sender' => auth()->user()->id,
            'receiver' => $receiver->id,
            'amount' => $request->get("amount"),
            'type' => "depot",
            'description' => "Transfert admin vers enrole",
        ]);
        $transfert->save();


        $receiver->balance = $receiver->balance + intval($request->get("amount"));
        $receiver->save();

        return redirect()->back()->with('success','Transfert effectué');

        /* $receiver = Enrole::query()
        ->where("uniq", $request->get("receiver"))->get([
            'id',
            'nom',
            'prenom',
            'created_at',
            'balance',
            ])->first();

            $sender = Enrole::query()->find($request->get("sender"));

            if ($sender) {
                if ($receiver) {
                    if ($receiver->id != $sender->id) {
                        if ($request->get("amount") > $sender->balance) {
                            throw ValidationException::withMessages(['Erreur de transfert! Le montant ne doit pas être supérieur à votre solde ' . $sender->balance]);
                            //return response()->json(["message" => 'Erreur de transfert! Le montant ne doit pas être supérieur à votre solde ' . $sender->balance], 422);
                        } else {
                            $transfert = new Transaction([
                                'sender' => $request->get("sender"),
                                'receiver' => $receiver->id,
                                'amount' => $request->get("amount"),
                                'type' => "depot",
                                'description' => "Transfert enrole vers enrole",
                            ]);
                            $transfert->save();

                            $sender->balance = $sender->balance - intval($request->get("amount"));
                            $receiver->balance = $receiver->balance + intval($request->get("amount"));
                            $sender->save();
                            $receiver->save();

                            throw ValidationException::withMessages(['Transféré avec succès']);
                            //return response()->json(["message" => 'Transféré avec succès.']);
                        }
                    } else {
                        throw ValidationException::withMessages(['Erreur de transfert! Vous ne pouvez pas vous transferer!']);
                        //return response()->json(["message" => 'Erreur de transfert! Vous ne pouvez pas vous transferer!'], 422);
                    }

                } else {
                    throw ValidationException::withMessages(['Erreur de transfert! Vérifier le numéro unique Sauvie du receveur']);
                    //return response()->json(["message" => 'Erreur de transfert! Vérifier le numéro unique Sauvie du receveur'], 422);
                }
            } else {
                throw ValidationException::withMessages(['Erreur de transfert! Vous n êtes pas dans la base de données']);
                //return response()->json(["message" => 'Erreur de transfert! Vous n êtes pas dans la base de données'], 422);
            } */
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
