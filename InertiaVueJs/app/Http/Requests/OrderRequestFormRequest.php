<?php

namespace App\Http\Requests;

use App\Models\OrderRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequestFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nom_initiateur' => ['required'],
            'email_initiateur' => ['required'],
            'matricule_initiateur' => ['required'],
            'direction' => ['required'],
            'date_demande_initiateur' => ['required'],
            'reference_agence' => ['required'],
            'localisation' => ['required'],
            'nom_client' => ['required'],
            'code_client' => ['required'],
            'category_client' => ['required'],
            'telephone_client' => ['required'],
            'reference_commande' => ['required'],
            'type_demande' => ['required'],
            'commentaire_regularisation' => [Rule::requiredIf($this->type_demande === 'REGULARISATION_DUNE_DEMANDE')],
            'mode_paiement' => ['required'],
            'reference_bordereau' => ['nullable', function ($attribute, $value, $fail) {
                $exists = OrderRequest::where([
                    'nom_banque' => $this->nom_banque,
                    'reference_bordereau' => $value,
                ])->exists();

                if ($exists) {
                    $fail('La référence du bordereau est déjà utilisée.');
                }
            }],
            'date_bordereau' => ['nullable'],
            'nom_banque' => ['nullable'],
            'numero_compte' => ['nullable'],
            'gl_bank_account' => ['nullable'],
            'montant_versement' => ['required'],
            'depositaire' => ['required'],
            'date_paiement_cash' => ['nullable'],
            'date_paiement_freemoney' => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nom_initiateur' => "Nom de l'initiateur",
            'email_initiateur' => "Adresse email de l'initiateur",
            'matricule_initiateur' => "Matricule de l'initiateur",
            'direction' => 'Direction',
            'date_demande_initiateur' => 'Date de demande',
            'reference_agence' => "Référence de l'agence",
            'localisation' => 'Localisation',
            'nom_client' => 'Nom du client',
            'telephone_client' => 'Numéro de téléphone du client',
            'code_client' => 'Code du client',
            'category_client' => 'Catégorie du client',
            'reference_commande' => 'Référence commande',
            'type_demande' => 'Type de demande',
            'commentaire_regularisation' => 'Commentaire régularisation',
            'mode_paiement' => 'Mode de paiement',
            'reference_bordereau' => 'Référence du bordereau',
            'date_bordereau' => 'Date du bordereau',
            'nom_banque' => 'Nom de la banque',
            'numero_compte' => 'Numéro de compte',
            'gl_bank_account' => 'GL Bank Account',
            'montant_versement' => 'Montant de versement',
            'depositaire' => 'Dépositaire',
        ];
    }
}
