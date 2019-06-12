<?php

require_once 'cart.php';
$price = array_sum($priceAll);

$private_key = openssl_pkey_get_private(
    "-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEAvRUGylRjczFydvZk65p36Day5Vh7uEgMOjpa2aUQzFgWolBb
CRhCR+Sc0kIG+qL8wFK4xqkFcWYdXnx+RrjAdCXjc01FlAbddOz79O/L1OlMk2Cs
vjj6+oHRbRvLNf0XQ6GjhzhE0pDjBwlHqIypekNAOSTL637y8SK+DdlbTMTetFAr
VXpA5ccQMl7BNLV/0+gIQLn6PV2MBXd8tWtg8a/Sbv75A3qPXZSisk+/36H1R6/S
z57oKIT2zTLNCfqAHfBAZSW4hXzoDnpjbCQKA6e9j4wdHDcnSeeo2m9Ja2PI3JSf
xKmUNTfCKMRvFtWeHliqgRqZnJV8GehEfLQijQIDAQABAoIBAGHwNDY1A9Y09I8+
DQQkXJuBSaSV8m9/kiXO+CPn5g2SSxcD/EN3t0050yjtXmQQbE7KCj+MaO9V7zxz
y4yiQb1nqqqcib+k1qyr284BL1k3Bp0H5DIbnZSIDYwwa0+pqpUzclqmAK/4sD+C
xQU+5sIXd3qh3qY6eWgBkOPng+z84EXU6YK5puRnjbmM1NajcL+WB8tStqwx5pSC
9HBuuYIwuI3sBaPgp0/Nh76j3HcAugo54RP4XBfqrR6VMFKUsa3qL95WmHBgI4K7
3uXThi19Pecu9dZ/5bZn8ybM+j36N7ifDtH/C+SNSVTb1RTgn5CngNtQK/opTTOp
2ju0J1kCgYEA4eyZmZrw19Ir8jBhYhNsA3ZDYpg6lhsRzt74HBPIMRuWISpsGlZk
fGovjSpTwvKl5QwevE1YpPJmOaykNsYMmoIFttmxar5SLsoGF8O7PiugXofKMtS9
JsnorcDJ56MBxCsuNO5cy0M4lLXTunvLkBeleLy9Q32UTJBg9RP/XQMCgYEA1kDd
OztOBHGg7FEYPwXVlEtfPab4bjPRVhYud12isIfhHIBnGlgnI4X2hALhvFHVjJkc
WjtQcWSN3GJgOxOciddAuM9p76OY61nJNuBF1ZhDYAXGbqoyAp/Wm4uM2Xj0GOmj
S67nnEnI5T8jIK73QiCmPfKhfFp7QWNQ4JGrBS8CgYBu4NOxk11ITpnKzvu8SpPk
TxJbPSLjsH1Y7g0OmpbRoxxXQp6zflrqxKJ5waBCORw6AWzENaGfsmeBPr2JNEHT
QqTTTJvKK4Xh+LxsxV8L8BVQz4vozofWlZlgTRHKYTHouNiAmcto5qDKO0Kib0dE
fJZ1Xwv0J5m0ydcL8LiPSQKBgQDJgA+Q2WGyhDtYhZxMCWypH4nfLd2Pp2RFlm71
DDcp12E7sPdGq4mDu0XxOdSbjEtPA+DKa+Zn/q38ivj+Fp+uc6cHKOr02ePD1JmM
5rhG/gC/mi7ZfW+zUChB+ajqDvtjQri1QTXKowoxsIOVBXi91H8E2+BMV7x77q/t
xJIXOQKBgE89C1FFDgiGV3vXaw4lQwqe74Qq0ydbnu5vyqV8B4+T08I8UgcSA1i+
XFqBNjz2fhsj5GP7DApHM/s9XlM1RB0Bui5WTzOoj9gv+ykZgvHf/1+bmdn9DNPp
Z4hU3TPwcxMuOMYqs6WzzcBqLtLlMds+PmBwF2U3uxEv1BlLTJlp
-----END RSA PRIVATE KEY-----");

// STEP 2. Define payment information
// ==================================

$fields = [
    "VK_SERVICE"  => "1011",
    "VK_VERSION"  => "008",
    "VK_SND_ID"   => "uid100010",
    "VK_STAMP"    => "12345",
    "VK_AMOUNT"   => $price,
    "VK_CURR"     => "EUR",
    "VK_ACC"      => "EE597700771234567897",
    "VK_NAME"     => "Sandra Poll",
    "VK_REF"      => "1234561",
    "VK_LANG"     => "EST",
    "VK_MSG"      => "Ostukorvi tooted",
    "VK_RETURN"   => "http://localhost/emptyCart.php",
    "VK_CANCEL"   => "http://localhost/emptyCart.php",
    "VK_DATETIME" => "2019-06-04T00:14:56+0300",
    "VK_ENCODING" => "utf-8",
];

// STEP 3. Generate data to be signed
// ==================================

// Data to be signed is in the form of XXXYYYYY where XXX is 3 char
// zero padded length of the value and YYY the value itself
// NB! LHV expects symbol count, not byte count with UTF-8,
// so use `mb_strlen` instead of `strlen` to detect the length of a string

$data = str_pad(mb_strlen($fields["VK_SERVICE"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_SERVICE"] .    /* 1011 */
    str_pad(mb_strlen($fields["VK_VERSION"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_VERSION"] .    /* 008 */
    str_pad(mb_strlen($fields["VK_SND_ID"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_SND_ID"] .     /* uid100010 */
    str_pad(mb_strlen($fields["VK_STAMP"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_STAMP"] .      /* 12345 */
    str_pad(mb_strlen($fields["VK_AMOUNT"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_AMOUNT"] .     /* 150 */
    str_pad(mb_strlen($fields["VK_CURR"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_CURR"] .       /* EUR */
    str_pad(mb_strlen($fields["VK_ACC"], "UTF-8"), 3, "0",
        STR_PAD_LEFT) . $fields["VK_ACC"] .        /* EE597700771234567897 */
    str_pad(mb_strlen($fields["VK_NAME"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_NAME"] .       /* Sandra Poll */
    str_pad(mb_strlen($fields["VK_REF"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_REF"] .        /* 1234561 */
    str_pad(mb_strlen($fields["VK_MSG"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_MSG"] .        /* Torso Tiger */
    str_pad(mb_strlen($fields["VK_RETURN"], "UTF-8"), 3, "0",
        STR_PAD_LEFT) . $fields["VK_RETURN"] .     /* http://localhost:8080/project/nSWjDIj4Ae6hZAVL?payment_action=success */
    str_pad(mb_strlen($fields["VK_CANCEL"], "UTF-8"), 3, "0",
        STR_PAD_LEFT) . $fields["VK_CANCEL"] .     /* http://localhost:8080/project/nSWjDIj4Ae6hZAVL?payment_action=cancel */
    str_pad(mb_strlen($fields["VK_DATETIME"], "UTF-8"), 3, "0",
        STR_PAD_LEFT) . $fields["VK_DATETIME"];    /* 2019-06-04T00:14:56+0300 */

/* $data = "0041011003008009uid10001000512345003150003EUR020EE597700771234567897011Sandra Poll0071234561011Torso Tiger069http://localhost:8080/project/nSWjDIj4Ae6hZAVL?payment_action=success068http://localhost:8080/project/nSWjDIj4Ae6hZAVL?payment_action=cancel0242019-06-04T00:14:56+0300"; */

// STEP 4. Sign the data with RSA-SHA1 to generate MAC code
// ========================================================

openssl_sign($data, $signature, $private_key, OPENSSL_ALGO_SHA1);

/* UFipaUi6nYfpD74JZqTO+S/RjUxsnlGLtsLXhNgRBeqgfk2zoWEcvJKFy5D6uZcUgse8zOJaAyDw+ihTJxPKadCXLc/xuPN/YF/mxhOA7DUYEg0+C3jUyuToU5WtMz9ErEdgt/eTNdzRxY2M0YS4vH4WZjS26LNyH3RlqwSoiO/rwjyM+NF1Yy/Yb99Pd82D/KefmqTiJkCNIWfvgeFhtYj1SJcfLlXRvk62zj0T2T3ersYRuBATEyoR7ld0Yk9VteCIK6Rd9iQ0FuVpj/OqiXnW/t1lp/m3iV/I6/pyaIczuRw07ZoKEDNi58+Lt2JteupadGCxKonS7fDNm+UtuQ== */
$fields["VK_MAC"] = base64_encode($signature);

// STEP 5. Generate POST form with payment data that will be sent to the bank
// ==========================================================================
