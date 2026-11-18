<?php
/**
 * API Cek Ketersediaan Jaringan & Cakupan ODP Fiber Optic
 * Ring Network
 */

header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../config/helper.php';

$query = trim($_GET['query'] ?? $_POST['query'] ?? '');

if (empty($query)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Silakan masukkan nama perumahan, kelurahan, atau kecamatan.'
    ]);
    exit;
}

try {
    // Search in coverage_areas table
    $searchTerm = '%' . $query . '%';
    $stmt = $pdo->prepare("SELECT * FROM coverage_areas WHERE is_active = 1 AND (area_name LIKE ? OR subdistrict LIKE ? OR city LIKE ? OR odp_code LIKE ? OR notes LIKE ?) ORDER BY sort_order ASC, id ASC LIMIT 5");
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    $results = $stmt->fetchAll();

    $waNumber = getSetting('whatsapp', '6281229342503');
    $cleanWa = preg_replace('/[^0-9]/', '', $waNumber);

    if (!empty($results)) {
        echo json_encode([
            'status' => 'found',
            'query' => $query,
            'count' => count($results),
            'results' => $results,
            'whatsapp' => $cleanWa
        ]);
    } else {
        // Build direct inquiry WA link
        $waMsg = "Halo Ring Network, saya ingin mengecek ketersediaan tiang ODP dan jaringan internet di area saya: *" . $query . "*. Apakah sudah bisa dipasang?";
        $waLink = "https://wa.me/{$cleanWa}?text=" . rawurlencode($waMsg);

        echo json_encode([
            'status' => 'not_found',
            'query' => $query,
            'message' => 'Area "' . $query . '" belum tercatat pada basis data ODP digital kami.',
            'whatsapp_url' => $waLink
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Gagal memproses data: ' . $e->getMessage()
    ]);
}
