<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Enrole;
use App\Models\PaymentOM;
use App\Models\Transaction;
use App\Models\TransactionPartenaire;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_enrole' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $transaction = Transaction::query()
            ->with("Sender")
            ->with("Receiver")
            ->with("Partenaire")
            ->where("sender", $request->get("id_enrole"))
            ->orWhere("receiver", $request->get("id_enrole"))
            ->get();

        return response()->json(["message" => 'Transaction de l\'enrole.', "transactions" => $transaction]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender' => 'required',
            'receiver' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $receiver = Enrole::query()
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
                        return response()->json(["message" => 'Erreur de transfert! Le montant ne doit pas être supérieur à votre solde ' . $sender->balance], 422);
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

                        return response()->json(["message" => 'Transféré avec succès.']);
                    }
                } else {
                    return response()->json(["message" => 'Erreur de transfert! Vous ne pouvez pas vous transferer!'], 422);
                }

            } else {
                return response()->json(["message" => 'Erreur de transfert! Vérifier le numéro unique Sauvie du receveur'], 422);
            }
        } else {
            return response()->json(["message" => 'Erreur de transfert! Vous n êtes pas dans la base de données'], 422);
        }

    }

    public function transactionPartenaire(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender' => 'required',
            'receiver' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $receiver = \App\Models\User::query()->find($request->get('receiver'));

        $sender = Enrole::query()
            ->where('uniq', $request->get('sender'))->get([
                'id',
                'nom',
                'prenom',
                'created_at',
                'balance',
            ])->first();

        if ($sender) {
            if ($receiver) {
                if ($receiver->id != $sender->id) {
                    if ($request->get("amount") > $sender->balance) {
                        return response()->json(["message" => 'Erreur de transfert! Le montant ne doit pas être supérieur à votre solde ' . $sender->balance], 422);
                    } else {
                        $transfert = new Transaction([
                            'sender' => $sender->id,
                            'receiver' => 0,
                            'partenaire' => $receiver->id,
                            'amount' => $request->get("amount"),
                            'type' => "transfert",
                            'description' => "Transfert enrole vers partenaire",
                        ]);
                        $transfert->save();

                        $sender->balance = $sender->balance - intval($request->get("amount"));
                        $receiver->balance = $receiver->balance + intval($request->get("amount"));
                        $sender->save();
                        $receiver->save();

                        return response()->json(["message" => 'Transféré avec succès.']);
                    }
                } else {
                    return response()->json(["message" => 'Erreur de transfert! Vous ne pouvez pas vous transferer!'], 422);
                }

            } else {
                return response()->json(["message" => 'Erreur de transfert! Vérifier le numéro du partenaire'], 422);
            }
        } else {
            return response()->json(["message" => 'Erreur de transfert! Vous n êtes pas dans la base de données'], 422);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function addPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'uniq' => 'required',
            'user' => 'required|numeric',
            'amount' => 'required|numeric',
            'otp' => 'required|numeric',
            'method' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = array(
            'amount' => $request->get('amount'),
            'otp' => $request->get('otp'),
            'phone' => $request->get('phone'),
        );

        $url = 'https://sauvie.aino-digital.com/view/om_api.php';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }
        curl_close($ch);
        $xml = simplexml_load_string('<response>' . $response . '</response>') or die('Error: Cannot create object');

        if ($xml->status == 200) {
            $payment = new PaymentOM([
                'user' => $request->get('user'),
                'amount' => $request->get('amount'),
                'phone' => $request->get('phone'),
                'otp' => $request->get('otp'),
            ]);
            $payment->save();

            $enrole = Enrole::query()->where('uniq', $request->get('uniq'))->get([
                'id',
                'nom',
                'prenom',
                'balance',
            ])->first();

            if ($enrole) {
                $enrole->balance += $request->get('amount');
                $enrole->save();
            }

            return response()->json([
                'message' => 'Payment saved successfully.',
            ], 201);
        } else {
            return response()->json([
                'message' => 'Une erreur dans le paiement.',
                'data' => $xml
            ]);
        }
    }
}
