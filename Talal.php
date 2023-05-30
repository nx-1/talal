<?php
require 'vendor/autoload.php';
use Telegram\Bot\Api;

$telegram = new Api('');

$updates = $telegram->getWebhookUpdates();
$message = $updates->getMessage();
$text = $message->getText();
$chat_id = $message->getChat()->getId();

switch ($text) {
    case '/start':
        $response = "مرحبًا بك في بوت حساب قروض العقارات!\nهذه الخدمة تحت التجربة والأرقام تقريبية.\n\nيرجى إدخال سعر العقار:";
        $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $response]);
        break;

    default:
        if (is_numeric($text)) {
            $property_price = floatval($text);
            $interest_rate = 0.03;
            $years = 20;

            $total_interest = $property_price * $interest_rate * $years;
            $total_amount = $property_price + $total_interest;
            $months = $years * 12;
            $installment = $total_amount / $months;
            $company_support = $total_interest / $months;
            $installment_after_support = $installment - $company_support;

            $response = "مبلغ العقار: " . number_format($property_price, 2) . " ريال\n";
            $response .= "المبلغ الإجمالي: " . number_format($total_amount, 2) . " ريال\n";
            $response .= "مبلغ القسط: " . number_format($installment, 2) . " ريال\n";
            $response .= "مبلغ دعم الشركة: " . number_format($company_support, 2) . " ريال\n";
            $response .= "مبلغ القسط بعد الدعم: " . number_format($installment_after_support, 2) . " ريال\n\n";
            $response .= "مع تحياتي,\nTalal";
        } else {
            $response = "الرجاء إدخال سعر العقار بالأرقام.";
        }
        $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $response]);
}
?>
