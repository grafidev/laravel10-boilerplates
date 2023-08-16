import intus from 'intus';
import { isNumeric, isRequired } from 'intus/rules';

export class InitiatorStepForm {
    static isValid(form) {
        return intus.validate({
            reference_agence: form.reference_agence,
            localisation: form.localisation,
        }, {
            reference_agence: [isRequired()],
            localisation: [isRequired()],
        }).passes();
    }
}

export class DealerStepForm {
    static isValid(form) {
        return intus.validate({
            nom_client: form.nom_client,
            telephone_client: form.telephone_client,
            category_client: form.category_client,
            code_client: form.code_client,
        }, {
            nom_client: [isRequired()],
            telephone_client: [isRequired()],
            category_client: [isRequired()],
            code_client: [isRequired()],
        }).passes();
    }
}


export class TransactionStepForm {
    static isValid(form) {
        return intus.validate({
            reference_commande: form.reference_commande,
            type_demande: form.type_demande,
        }, {
            reference_commande: [isRequired()],
            type_demande: [isRequired()],
        }).passes();
    }
}

export class PaymentStepForm {
    static isValid(form) {
        return intus.validate({
            montant_versement: form.montant_versement,
            mode_paiement: form.mode_paiement,
            nom_banque: form.nom_banque,
            numero_compte: form.numero_compte,
            gl_bank_account: form.gl_bank_account,
            reference_bordereau: form.reference_bordereau,
            depositaire: form.depositaire,
        }, {
            montant_versement: [isRequired(), isNumeric()],
            mode_paiement: [isRequired()],
            nom_banque: [],
            numero_compte: [],
            gl_bank_account: [],
            reference_bordereau: [],
            depositaire: [isRequired()],
        }).passes();
    }
}