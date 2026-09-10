<?php //db.php — conexão única reaproveitada em todas as páginas
function db(): PDO {
static $pdo = null;
if ($pdo === null) {
$pdo = new
PDO('mysql:host=localhost;dbname=migracao;charset=utf8mb4',
'root', '', [PDO::ATTR_ERRMODE =>
PDO::ERRMODE_EXCEPTION]);
}
return $pdo;
}

?>

/**
 * Conexao PDO unica (singleton de pobre).
 * Em ambiente de teste, defina BIBLIOTECA_DB antes do require pra usar outro banco.
 *
 *   putenv('BIBLIOTECA_DB=biblioteca_teste');
 */

// function db(): PDO {
//     static $pdo = null;
//     if ($pdo === null) {
//         $host = getenv('BIBLIOTECA_HOST') ?: '127.0.0.1';
//         $base = getenv('BIBLIOTECA_DB')   ?: 'db_migracao';
//         $user = getenv('BIBLIOTECA_USER') ?: 'root';
//         $pass = getenv('BIBLIOTECA_PASS') ?: '';

//         $dsn  = "mysql:host={$host};dbname={$base};charset=utf8mb4";
//         $pdo  = new PDO($dsn, $user, $pass, [
//             PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//             PDO::ATTR_EMULATE_PREPARES   => false,
//         ]);
//     }
//     return $pdo;
// }

// /** Reseta a conexao (uso em testes que trocam de banco no meio). */
// function db_reset(): void {
//     // hack: usa reflexao no static via fechamento sobre db()
//     // jeito mais simples: re-incluir nao funciona. Vamos so re-criar.
//     $GLOBALS['__db_reset_flag'] = true;
