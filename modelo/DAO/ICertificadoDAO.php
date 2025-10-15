<?php
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
interface ICertificadoDAO {
    public function crear(Certificado $certificado);
    public function obtenerPorId($id);
    public function obtenerPorCodigo($codigo);
    public function obtenerPorUsuario($id_usuario);
    public function verificarCertificado($codigo);
}
