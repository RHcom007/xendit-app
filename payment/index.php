<?php
include __DIR__ . '/../vendor/autoload.php';

use Xendit\Xendit;

class Payment
{

    public function __construct()
    {
        // Xendit::setApiKey('xnd_production_vNJxv2DvNdple1SIl3p4uKvO55NWRcMQbRNwC3Dw7jmRYyGMhKVZoKW9NAEiD');
        Xendit::setApiKey('xnd_development_19yWiX5t12my3Aih9ozSIyzRjLpaneBpYAkQgFv08v4mS8gpzGeUTfVLUpgjs15');
    }

    public function createInvoice($userId, $invoiceDescription, $invoiceAmount)
    {
        $invoiceId = 'KIMS' . random_int(1000000, 9999999) . $userId; // ?? INVOICE ID SIMPAN UNTUK USER
        $params = [
            'external_id' => $invoiceId,
            'amount' => $invoiceAmount,
            'description' => $invoiceDescription,
            'invoice_duration' => 86400,
            'payer_email' => 'email@customer.com',
            'success_redirect_url' => 'https://3c11-2001-448a-10f0-2d04-b9b2-6ae0-2627-a86d.ngrok-free.app?success=trueInvId=' . $invoiceId,
            'failure_redirect_url' => 'https://3c11-2001-448a-10f0-2d04-b9b2-6ae0-2627-a86d.ngrok-free.app?success=falseInvId=' . $invoiceId,
            'currency' => 'IDR',
            // 'for-user-id' => $userId,
        ];
        $createInvoice = \Xendit\Invoice::create($params);
        $db = new db;
        $db->insertInvoices('123',$createInvoice['id'],$invoiceId);

        header('Location: '.$createInvoice["invoice_url"]);
        die();
    }

    public function ValidateInvoice($invoiceId){
        $recheck = \Xendit\Invoice::retrieve($invoiceId);
        if($recheck['status'] === "PAID"){
            return true;
        }
        return false;
    }
}
