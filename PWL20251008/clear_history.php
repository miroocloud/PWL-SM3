<?php
function clearHistory() {
    $file = 'history.json';
    
    if (file_exists($file)) {
        if (unlink($file)) {
            return "success";
        } else {
            return "error_delete";
        }
    } else {
        return "file_not_found";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = clearHistory();

    $message = '';
    $alertType = '';

    switch ($result) {
        case 'success':
            $message = 'Riwayat berhasil dihapus!';
            $alertType = 'success';
            break;
        case 'file_not_found':
            $message = 'File riwayat tidak ditemukan.';
            $alertType = 'warning';
            break;
        case 'error_delete':
        default:
            $message = 'Gagal menghapus riwayat!';
            $alertType = 'danger';
            break;
    }

    $response = [
        'status' => $result,
        'message' => $message,
        'alertType' => $alertType
    ];

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}
?>