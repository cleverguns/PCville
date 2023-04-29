//<?php
session_start();
require_once("../wp-includes/autoLoader.php");
require_once("../wp-includes/utils.php");

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

if (isset($_POST['checkout'])) {
    $amount = $_POST['amount'];
    //remove the two 00 at the last of amount 'caused by paymongo.
    $newAmount = substr($amount, 0, -2);
    $newAmount = (int) $newAmount;

    $user_id = $_SESSION["user_token"];
    

   
    $fname =  $_POST['fname'];
    $lname =  $_POST['lname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $postal_code = $_POST['postal'];
    $province = $_POST['province'];
    $transaction_token = generate_token('15');
    $name = $_POST['fname'] . ' ' . $_POST['lname'];
    $description = $_POST['description'];
    $additional_address = $_POST['additional_address'];

    if(empty($_POST["billing_id"])){
        $billing_id = "bid_" . generate_number(11);
    }else{
        $billing_id = $_POST["billing_id"];
    }
    //=======================================================//
    $type = $_POST['payment'];

    $_SESSION['product'] = array();
    for ($i = 0; $i < count($_POST['product']); $i++) {
        $product = $_POST['product'][$i];
        $qty = $_POST['stock'][$i];
        $_SESSION['product'][] = array("product_id" => $product, "quantity" => $qty);
    }

    if ($type == "gcash") {
        $check_same = $conn->query("SELECT billing_id FROM tbl_billings WHERE user_id = '{$user_id}' LIMIT 1");
        if ($check_same->num_rows > 0) {
            $fetch_billing = $check_same->fetch_assoc();
            $fetch_id = $fetch_billing['billing_id'];
            $billing->costumerBilling($user_id, $fname, $lname, $email, $province, $contact, $address1, $address2, $additional_address, $postal_code, $billing_id);
            if ($transaction->add_transaction($user_id, $transaction_token, $type, $newAmount, $description, "Pending") == "success") {
                payment($billing_id, $transaction_token, $amount, $type, $name, $email, $contact, $address1, $address2, $additional_address, $postal_code, $province, $description);
            }

        } else {
            $billing->saveBilling($user_id, $billing_id, $fname, $lname, $email, $province, $contact, $address1, $address2, $postal_code);
            if ($transaction->add_transaction($user_id, $transaction_token, $type, $newAmount, $description, "Pending") == "success") {
                payment($billing_id, $transaction_token, $amount, $type, $name, $email, $contact, $address1, $address2, $postal_code, $province, $description);
            }
        }
    } else {
        $check_same = $conn->query("SELECT billing_id FROM tbl_billings WHERE user_id = '{$user_id}' LIMIT 1");
        if ($check_same->num_rows > 0) {
            $billing->costumerBilling($user_id, $fname, $lname, $email, $province, $contact, $address1, $address2, $additional_address, $postal_code, $billing_id);
            if ($transaction->add_transaction($user_id, $transaction_token, $type, $newAmount, $description, "Pending") == "success") {
                header("Location: ../success.php?_token=" . $_SESSION['csrf_token'] . "&_key=" . $transaction_token . "&_bid=" . $billing_id);
            }
        } else {
            $billing->saveBilling($user_id, $billing_id, $fname, $lname, $email, $province, $contact, $address1, $address2, $additional_address, $postal_code);
            if ($transaction->add_transaction($user_id, $transaction_token, $type, $newAmount, $description, "Pending") == "success") {
                header("Location: ../success.php?_token=" . $_SESSION['csrf_token'] . "&_key=" . $transaction_token . "&_bid=" . $billing_id);
            }
        }
    }
}


function payment($billing_id, $transaction_token, $amount, $type, $name, $email, $contact, $line1, $line2, $postal, $city, $description)
{

   // $private_key = "sk_test_NnHmCEPUWJBbB8r1QkJPj48p";
    $private_key = "sk_live_iF2S7mnuoBupUXWxs1rwrv9Z";
    $secret_key = base64_encode($private_key);

    $api_url = "https://api.paymongo.com/v1/sources";

    $uri_success = "https://pcvillage.shop/success.php?_token=" . $_SESSION['csrf_token'] . "&_key=" . $transaction_token . "&_bid=" . $billing_id;
    $uri_failed = "https://pcvillage.shop/failed.php?_token=" . $_SESSION['csrf_token'] . "&_key=" . $transaction_token . "&_bid=" . $billing_id;
    $redirect = [
        "success" => $uri_success,
        "failed" => $uri_failed,
    ];

    $attributes = [
        'amount' => intval($amount),
        'redirect' => $redirect,
        'billing' => [
            'name' => $name,
            'email' => $email,
            'phone' => $contact,
            'address' => [
                'line1' => $line1,
                'line2' => $line2,
                'city' => $city,
                'state' => 'PH',
                'postal_code' => $postal,
                'country' => 'PH'
            ]
        ],
        'livemode' => false,
        'status' => 'pending',
        'type' => 'gcash', //grab_pay, gcash, maya
        'currency' => 'PHP',
        'description' => $description
    ];

    $source = [
        "data" => [
            "attributes" => $attributes
        ]
    ];

    $headers = array(
        "accept: application/json",
        "authorization: Basic " . $secret_key,
        "content-type: application/json"
    );

    // Initialize curl
    $curl = curl_init();


    curl_setopt_array($curl, array(
        CURLOPT_URL => $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($source),
        CURLOPT_HTTPHEADER => $headers,
    ));

    $result = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $resData = json_decode($result, true);
    if ($err) {
        echo ("Error : " . $err);
    } else {
        //print_r($resData);
        $checkoutUrl = $resData['data']['attributes']['redirect']['checkout_url'];
        header("Location: " . $checkoutUrl);
    }
}
?>