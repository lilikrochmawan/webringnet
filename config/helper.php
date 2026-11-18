<?php
/**
 * Helper Functions
 * Ring Network Application
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';

/**
 * Escape HTML output
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Get setting value from database with fallback
 */
function getSetting($key, $default = '') {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT value FROM settings WHERE key = ?");
        $stmt->execute([$key]);
        $val = $stmt->fetchColumn();
        return ($val !== false) ? $val : $default;
    } catch (Exception $e) {
        return $default;
    }
}

/**
 * Set flash message
 */
function setFlash($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type, // 'success', 'danger', 'warning', 'info'
        'message' => $message
    ];
}

/**
 * Get and clear flash message
 */
function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Format Indonesian Rupiah
 */
function formatRupiah($amount) {
    $clean = preg_replace('/[^0-9]/', '', (string)$amount);
    if (!empty($clean)) {
        return 'Rp ' . number_format((float)$clean, 0, ',', '.');
    }
    return $amount;
}

/**
 * Generate Direct WhatsApp Link with pre-filled message
 */
function getWaLink($customText = '') {
    $waNumber = getSetting('whatsapp', '6281229342503');
    $cleanNumber = preg_replace('/[^0-9]/', '', $waNumber);
    if (substr($cleanNumber, 0, 1) === '0') {
        $cleanNumber = '62' . substr($cleanNumber, 1);
    }
    if (empty($customText)) {
        $customText = "Halo Ring Network, saya ingin menanyakan tentang layanan internet dan solusi jaringan.";
    }
    return "https://wa.me/{$cleanNumber}?text=" . rawurlencode($customText);
}

/**
 * Fetch dynamic navbar dropdown menus
 */
function getNavbarMenus() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM navbar_menus WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Fetch all active services
 */
function getActiveServices() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Fetch active internet packages by category
 */
function getInternetPackages($category = 'home') {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT * FROM internet_packages WHERE category = ? AND is_active = 1 ORDER BY sort_order ASC, id ASC");
        $stmt->execute([$category]);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}
