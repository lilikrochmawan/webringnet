<?php
/**
 * Submit Inquiry & Order API
 * Ring Network
 */

header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../config/helper.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak diizinkan.']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$packageOrService = trim($_POST['package_or_service'] ?? '');
$address = trim($_POST['address'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name)) {
    echo json_encode(['status' => 'error', 'message' => 'Nama lengkap wajib diisi.']);
    exit;
}

if (empty($phone)) {
    echo json_encode(['status' => 'error', 'message' => 'Nomor WhatsApp/HP wajib diisi.']);
    exit;
}

try {
    // 1. Insert into database
    $stmt = $pdo->prepare("INSERT INTO inquiries (name, phone, email, package_or_service, address, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $phone, $email, $packageOrService, $address, $message]);
    $inquiryId = $pdo->lastInsertId();

    // 2. Build WhatsApp redirect URL
    $adminWa = getSetting('whatsapp', '6281229342503');
    $cleanAdminWa = preg_replace('/[^0-9]/', '', $adminWa);
    if (substr($cleanAdminWa, 0, 1) === '0') {
        $cleanAdminWa = '62' . substr($cleanAdminWa, 1);
    }

    $waMessage = "*[PERMINTAAN PASANG / KONSULTASI RING NETWORK]*\n\n"
               . "Halo Ring Network, saya telah mengisi formulir pemesanan di website:\n\n"
               . "• *ID Tiket:* #RN-{$inquiryId}\n"
               . "• *Nama:* {$name}\n"
               . "• *No. WhatsApp:* {$phone}\n"
               . (!empty($email) ? "• *Email:* {$email}\n" : "")
               . "• *Layanan / Paket:* " . (!empty($packageOrService) ? $packageOrService : "Konsultasi Umum") . "\n"
               . (!empty($address) ? "• *Alamat / Lokasi Pasang:* {$address}\n" : "")
               . (!empty($message) ? "• *Catatan Tambahan:* {$message}\n" : "")
               . "\nMohon info ketersediaan jaringan dan jadwal survey/pemasangan. Terima kasih!";

    $waUrl = "https://wa.me/{$cleanAdminWa}?text=" . rawurlencode($waMessage);

    echo json_encode([
        'status' => 'success',
        'message' => 'Data Anda berhasil dikirim! Tim Ring Network akan segera menghubungi Anda.',
        'inquiry_id' => $inquiryId,
        'whatsapp_url' => $waUrl
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Gagal menyimpan data: ' . $e->getMessage()
    ]);
}
