<?php

/**
 * AJAX отправка формы (только наши формы).
 * Совместимо с PHP 5.6
 */

function sendOrder() {

  // Только AJAX
  if ( ! function_exists('wp_doing_ajax') || ! wp_doing_ajax() ) {
    wp_die('Bad Request', 400);
  }

  // Только наши запросы (маркер из JS)
  if ( empty($_POST['perspectiva_form']) || $_POST['perspectiva_form'] !== '1' ) {
    wp_die('Not allowed', 400);
  }

  $to   = 'info@fasad-material.ru';
//  $to   = 'evstifeevoleg1989@gmail.com';
  $from = 'no-reply@fasad-material.ru';

  // Тема
  $subject_raw = isset($_POST['form_subject']) ? trim(strip_tags($_POST['form_subject'])) : 'Заявка с сайта';
  $subject_raw = htmlspecialchars($subject_raw, ENT_QUOTES, 'UTF-8');
  $subject     = "=?UTF-8?B?" . base64_encode($subject_raw) . "?=";

  // boundary
  $boundary = 'boundary_' . md5(uniqid('', true));

  // Заголовки
  $headers  = "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";
  $headers .= "From: {$from}\r\n";
  $headers .= "Reply-To: {$from}\r\n";
  $headers .= "Return-Path: {$from}\r\n";
  $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

  // Plain-text часть
  $message_plain = "";
  foreach ($_POST as $key => $value) {
    if ($value === "" || $key === "form_subject" || $key === "perspectiva_form") {
      continue;
    }
    $k = strip_tags($key);
    $v = strip_tags($value);
    $message_plain .= $k . ": " . $v . "\n";
  }

  // HTML часть
  $rows = "";
  $c = true;

  foreach ($_POST as $key => $value) {
    if ($value === "" || $key === "form_subject" || $key === "perspectiva_form") {
      continue;
    }

    $k = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
    $v = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

    $rows .= "<tr" . (($c = !$c) ? "" : " style=\"background-color:#f8f8f8;\"") . ">
      <td style=\"padding:10px;border:#e9e9e9 1px solid;\"><b>{$k}</b></td>
      <td style=\"padding:10px;border:#e9e9e9 1px solid;\">{$v}</td>
    </tr>";
  }

  $message_html = "<html><head><meta charset=\"UTF-8\"></head><body>
    <table style=\"width:100%;\">{$rows}</table>
  </body></html>";

  // Multipart сообщение
  $message  = "--{$boundary}\r\n";
  $message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
  $message .= $message_plain . "\r\n";
  $message .= "--{$boundary}\r\n";
  $message .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
  $message .= $message_html . "\r\n";
  $message .= "--{$boundary}--\r\n";

  // Отправка
  $sent = mail($to, $subject, $message, $headers);

  if ($sent) {
    wp_send_json_success(array('message' => 'Удачно отправлено'));
  } else {
    wp_send_json_error(array('message' => 'Ошибка при отправке письма'));
  }
}

// Регистрируем AJAX action
add_action('wp_ajax_sendOrder', 'sendOrder');
add_action('wp_ajax_nopriv_sendOrder', 'sendOrder');